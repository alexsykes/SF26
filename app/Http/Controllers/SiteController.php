<?php

namespace App\Http\Controllers;

use App\Mail\EntryChanged;
use App\Mail\SuggestionAcknowledgement;
use App\Mail\SuggestionReviewCompleted;
use App\Models\Site;
use App\Models\Suggestion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

function sendmail(int $suggestionID, string $site_name)
{
    $suggestionObject = Suggestion::find($suggestionID);
    $suggestion = $suggestionObject->suggestion;
    $userID = $suggestionObject->userID;
    $siteID = $suggestionObject->siteID;
    $user = User::find($userID);
    $email = $user->email;
    $name = $user->name;

    info("Send mail to $name: " . $email);

    Mail::to($email)->send(new SuggestionReviewCompleted($name, $suggestion, $site_name, $siteID));
}

class SiteController extends Controller
{
    public function index($id)
    {
        $user = auth()->user();
        $site = Site::where('id', $id)->first();
        return view('site.detail', compact('site', 'user'));
    }

    function sites()
    {
        if (!isset($_COOKIE['lat']) || !isset($_COOKIE['lng'])) {
            $curLat = 53.59476;
            $curLng = -2.56092;
        } else {
            $curLat = $_COOKIE['lat'];
            $curLng = $_COOKIE['lng'];
        }

        $sites = Site::select(DB::raw("id, site_name, site_description, begin, end, lat, lng, `from`, `to`, ROUND(ST_Distance_Sphere(point(lat, lng), point($curLat,$curLng))/1000) as distance_km"))
            ->orderBy('site_name', 'asc')
            ->get()
            ->toArray();

        $user_id = auth()->user()->id;

        $siteIDs = User::where('id', $user_id)
            ->select('favourites')
            ->first();

        $siteIDArray = explode(',', $siteIDs['favourites']);

        $favourites = auth()->user()->favourites;
//        dd($favourites);

        return view('site.list', compact('sites', 'favourites'));
    }

    public function update_request($id)
    {
        $site = Site::where('id', $id)->first();
        $user = auth()->user();
        return view('site.update_form', compact('site', 'user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => ['required', 'min:5', 'max:255'],
            'site_access' => 'required',
            'site_description' => 'required',
            'near' => 'required',
            'from' => 'required',
            'to' => 'required',
        ]);

        $directions = array("N", "NNE", "NE", "ENE", "E", "ESE", "SE", "SSE", "S", "SSW", "SW", "WSW", "W", "WNW", "NW", "NNW");

        $siteID = $request->input('siteID');
        $site = Site::where('id', $siteID)->first();

        $beginIndex = \request()->integer('from');
        $endIndex = \request()->integer('to');
        $site->end = $directions[$endIndex];
        $site->begin = $directions[$beginIndex];

        $site->site_wind_directions = $directions[$beginIndex] . " to " . $directions[$endIndex];

        $site->site_name = $request->input('site_name');
        $site->site_description = $request->input('site_description');
        $site->site_access = $request->input('site_access');
        $site->w3w = $request->input('w3w');
        $site->from = $request->input('from');
        $site->to = $request->input('to');
        $site->update();

//      Process Suggestions
        if ($request->input('completed') !== null) {
            $completed = $request->input('completed');
            foreach ($completed as $completedID) {
                $suggestion = Suggestion::where('id', $completedID)->first();
                $suggestion->completed = true;
                $suggestion->completed_at = now();
                $suggestion->update();
                sendmail($completedID, $site->site_name);
            }
        }
        return redirect('/suggestions');
    }

    public function site_user_update(Request $request)
    {
        $user = auth()->user();
        $siteID = $request->input('site_id');
        $site = Site::where('id', $siteID)->first();
        $site_name = $site->site_name;

        $attributes['userID'] = $user->id;
        $attributes['siteID'] = $siteID;
        $attributes['suggestion'] = $request->input('comment');
        $attributes['completed'] = false;

        Suggestion::create($attributes);

        Mail::to($user->email)
            ->bcc('ale@alexsykes.net')
            ->send(new SuggestionAcknowledgement($user->name, $site_name, $attributes['suggestion']));

        return view('site.acknowledge');
    }


}
