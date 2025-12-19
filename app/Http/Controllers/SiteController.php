<?php

namespace App\Http\Controllers;

use App\Mail\AcknowledgeSiteSubmission;
use App\Mail\EntryChanged;
use App\Mail\SitePublished;
use App\Mail\SuggestionAcknowledgement;
use App\Mail\SuggestionReviewCompleted;
use App\Models\Forecast;
use App\Models\Site;
use App\Models\Suggestion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
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

function convertToDirection(int $input)
{
    $directions = array("N", "NNE", "NE", "ENE", "E", "ESE", "SE", "SSE", "S", "SSW", "SW", "WSW", "W", "WNW", "NW", "NNW");
    return $directions[$input];
}

class SiteController extends Controller
{
    public function index($id)
    {
        $user = auth()->user();
        $site = Site::where('id', $id)->first();

        $hits = $site->hits;
        $site->hits = $hits + 1;
        $site->save();

        return view('site.detail', compact('site', 'user'));
    }

    function sites()
    {
        if (!isset($_COOKIE['curLat']) || !isset($_COOKIE['curLat'])) {
            $curLat = 53.59476;
            $curLng = -2.56092;

            setcookie(
                'curLat',
                $curLat,
                [
                    'expires' => time() + 3600 * 24 * 365,
                    'path' => '/',
                ]
            );

            setcookie(
                'curLng',
                $curLng,
                [
                    'expires' => time() + 3600 * 24 * 365,
                    'path' => '/',
                ]
            );
        } else {
            $curLat = $_COOKIE['curLat'];
            $curLng = $_COOKIE['curLng'];
        }

        if (!isset($_COOKIE['curZoom'])) {
            setcookie(
                'curZoom',
                7,
                [
                    'expires' => time() + 3600 * 24 * 365,
                    'path' => '/',
                ]
            );
        }

        $sites = Site::select(DB::raw("id, site_name, site_description, begin, end, lat, lng, `from`, `to`, ROUND(ST_Distance_Sphere(point(lat, lng), point($curLat,$curLng))/1000) as distance_km"))
            ->where('sites.published', true)
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

        $sitesForMap = Site::all()
            ->where('published', true)
            ->select('id', 'site_name', 'lat', 'lng', 'begin', 'end')
            ->toArray();


        return view('site.list', compact('sites', 'favourites', 'sitesForMap'));
    }

    public function sites_near()
    {
        $user = Auth::user();

        $userFavourites = $user->favourites;
        $numSites = 3;

        if (!isset($_COOKIE['lat']) || !isset($_COOKIE['lng'])) {
            $curLat = 53.59476;
            $curLng = -2.56092;
        } else {
            $curLat = $_COOKIE['curLat'];
            $curLng = $_COOKIE['curLng'];
        }

        $localSites = Site::select(DB::raw("id, site_name, site_description, near, site_access, w3w, begin, end, lat, lng, updated_at, `from`, `to`, ST_Distance_Sphere(point(lat, lng), point($curLat,$curLng))/1000 as distance_km"))
            ->where('sites.published', true)
            ->orderBy('distance_km', 'asc')
            ->limit($numSites)
            ->get()
            ->toArray();

        $allSites = Site::select(DB::raw("id, site_name, site_description, begin, end, lat, lng, `from`, `to`, ROUND(ST_Distance_Sphere(point(lat, lng), point($curLat,$curLng))/1000) as distance_km"))
            ->where('sites.published', true)
            ->orderBy('distance_km', 'asc')
            ->get()
            ->toArray();

//        dd($localSites);
        return view('dashboard', compact('localSites', 'curLat', 'curLng', 'allSites', 'userFavourites'));
    }

    public function update_request($id)
    {
        $site = Site::where('id', $id)->first();
        $user = auth()->user();
        return view('site.update_form', compact('site', 'user'));
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

        $message = "Thank you for your submission. We will review comments and get back to you as soon as possible.";
        return view('site.acknowledge', ['message' => $message]);
    }

    public function nearest(Request $request)
    {
//      Setup data arrays and get location if set
        $directions = ["N", "NNE", "NE", "ENE", "E", "ESE", "SE", "SSE", "S", "SSW", "SW", "WSW", "W", "WNW", "NW", "NNW"];

        if (!isset($_COOKIE['curLat']) || !isset($_COOKIE['curLng'])) {
            $curLat = -2.547855;
            $curLng = 54.00366;
        } else {
            $curLat = $_COOKIE['curLat'];
            $curLng = $_COOKIE['curLng'];
        }

//      Get data for nearest site
        //      Find the nearest site
        $nearestSite = DB::table('sites')
            ->selectRaw("sites.id, forecasts.data,  ST_Distance_Sphere(point(lat, lng), point($curLat,$curLng))/1000 as distance_km")
            ->where('sites.published', true)
            ->leftJoin('forecasts', 'sites.id', '=', 'forecasts.site_id')
            ->orderBy('distance_km', 'asc')
            ->first();

        $siteID = $nearestSite->id;
        $json = $nearestSite->data;

        $data = json_decode($json);
        $current = $data->current;

        $wind_speed = $current->wind_speed;
        $wind_deg = $current->wind_deg;

        $windIndex = (int)(($wind_deg * 16 / 360) + 0.5);

        if ($windIndex == 16) {
            $windIndex = 0;
        }

//      Check whether request includes wind direction
        if ($request->windDirection) {
            $direction = $request->windDirection;
            $windIndex = array_search($direction, $directions);
        }

        $wind_dir = $directions[$windIndex];

        $site = Site::where('sites.id', $siteID)
            ->leftJoin('forecasts', 'sites.id', '=', 'forecasts.site_id')
            ->first();

        $site_directions = DB::table('site_wind_directions')
            ->where('siteID', $siteID)
            ->select('direction')
            ->get()
            ->toArray();
        $site_winds = array();

        foreach ($site_directions as $site_direction) {
            $site_winds[] = $site_direction->direction;
        }

        setcookie("nearestSiteID", $siteID, time() + (86400 * 30), "/");

        $sitesForDirection = DB::table("site_wind_directions")
            ->selectRaw("sites.*, forecasts.*, ST_Distance_Sphere(point(lat, lng), point($curLat,$curLng))/1000 as distance_km")
            ->leftJoin("sites", "site_wind_directions.siteID", "=", "sites.id")
            ->leftJoin('forecasts', 'sites.id', '=', 'forecasts.site_id')
            ->where("direction", $windIndex)
            ->where('sites.published', true)
            ->orderBy('distance_km', 'asc')
//            ->limit(10)
            ->get()
            ->toArray();

//        dd($sitesForDirection[0]);

//        $sitesForDirection = Site::all()
//            ->where('published', true)
//            ->select('id', 'site_name', 'lat', 'lng', 'begin', 'end')
//            ->toArray();

        return view('site.nearest', ['current' => $current, 'directions' => $directions, 'sites' => $sitesForDirection, 'nearestSite' => $site, 'site_winds' => $site_winds, 'windIndex' => $windIndex, 'wind_dir' => $wind_dir]);
    }

    public function direction(Request $request)
    {
        $directions = ["N", "NNE", "NE", "ENE", "E", "ESE", "SE", "SSE", "S", "SSW", "SW", "WSW", "W", "WNW", "NW", "NNW", "N"];

        if (!isset($_COOKIE['lat']) || !isset($_COOKIE['lng'])) {
            $curLat = -2.547855;
            $curLng = 54.00366;
        } else {
            $curLat = $_COOKIE['lat'];
            $curLng = $_COOKIE['lng'];
        }

        $dir = $request->input('windDirection');
        $windIndex = array_search($dir, $directions);

        $sitesForDirection = DB::table("site_wind_directions")
            ->selectRaw("sites.*, forecasts.*, ST_Distance_Sphere(point(lat, lng), point($curLat,$curLng))/1000 as distance_km")
            ->leftJoin("sites", "site_wind_directions.siteID", "=", "sites.id")
            ->leftJoin('forecasts', 'sites.id', '=', 'forecasts.site_id')
            ->where("direction", $windIndex)
            ->where('sites.published', true)
            ->orderBy('distance_km', 'asc')
            ->limit(10)
            ->get()
            ->toArray();

        return view('site.byDirection', compact('directions', 'sitesForDirection', 'windIndex'));
    }

    public function addSite()
    {
        return view('site.add');
    }

    public function storeSite(Request $request)
    {
        $user = auth()->user();
        $userID = $user->id;
        $email = $user->email;

        $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'site_access' => ['required'],
            'site_description' => ['required'],
            'near' => ['required'],
            'to' => ['required'],
            'from' => ['required'],
        ]);

        $w3w = $request->input('w3w');


        $begin = convertToDirection($request->input('from'));
        $end = convertToDirection($request->input('to'));

        $site = Site::create([
            'site_name' => $request->input('site_name'),
            'site_access' => $request->input('site_access'),
            'site_description' => $request->input('site_description'),
            'near' => $request->input('near'),
            'to' => $request->input('to'),
            'from' => $request->input('from'),
            'created_by' => $userID,
            'lat' => $request->input('latInput'),
            'lng' => $request->input('lngInput'),
            'hits' => 0,
            'w3w' => $w3w,
            'end' => $end,
            'begin' => $begin,
        ]);

        Mail::to($user->email)
            ->bcc('alex@alexsykes.net')
            ->send(new AcknowledgeSiteSubmission($user->name, $site));

        $this->updateWindDirections($site);
        $message = "Thank you for your submission. We will review the site and get back to you as soon as possible. Please note that the site will not appear in our listings until it is approved.";
        return view('site.acknowledge', ['message' => $message]);

    }

    private function updateWindDirections(?Site $site)
    {
//        Delete existing
        $siteID = $site->id;
        $deleted = DB::table('site_wind_directions')->where('siteID', $siteID)->delete();

//        Set up direction array
        $directions = array("N", "NNE", "NE", "ENE", "E", "ESE", "SE", "SSE", "S", "SSW", "SW", "WSW", "W", "WNW", "NW", "NNW");

        $numDirs = count($directions);

//        Get end points
        $beginIndex = $site->from;
        $endIndex = $site->to;


//        dd($siteID, $beginIndex, $endIndex);

        if ($endIndex > $beginIndex) {
            for ($i = $beginIndex; $i <= $endIndex; $i++) {
                $site_wind_direction = \App\Models\SiteWindDirections::create([
                    'siteID' => $siteID,
                    'direction' => $i,
                ]);
            }
        } elseif ($endIndex == $beginIndex) {
            $site_wind_direction = \App\Models\SiteWindDirections::create([
                'siteID' => $siteID,
                'direction' => $endIndex,
            ]);
        } else {
            for ($i = $beginIndex; $i < $numDirs; $i++) {
                $site_wind_direction = \App\Models\SiteWindDirections::create([
                    'siteID' => $siteID,
                    'direction' => $i,
                ]);
            }
            for ($i = 0; $i <= $endIndex; $i++) {
                $site_wind_direction = \App\Models\SiteWindDirections::create([
                    'siteID' => $siteID,
                    'direction' => $i,
                ]);
            }
        }
    }

    public function publishSite(Request $request)
    {
        $site = Site::find($request->input('siteID'));
        $site->published = true;
        $site->update();

        $user = auth()->user();
        $name = $user->name;
//dd($name);
        Mail::to($user->email)
            ->bcc('alex@alexsykes.net')
            ->send(new SitePublished($name, $site));

        $this->getForecast($site);

        return redirect('/sites_approve');
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
//         Site updated - now update site_wind_directions

        $this->updateWindDirections($site);

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

    private function getForecast(Site $site)
    {
        $open_weather = Config::get('app.OPEN_WEATHER');
        $lat = $site->lat;
        $lng = $site->lng;

        $url = "https://api.openweathermap.org/data/3.0/onecall?lat=$lat&lon=$lng&exclude=minutely,alerts&units=imperial&appid=" . $open_weather;

        if (!$site->forecast) {
            $rawData = (file_get_contents($url, 'r'));
            Forecast::create([
                'site_id' => $site->id,
                'data' => $rawData,
                'version' => 1,
            ]);
        }
    }

    function sitemap()
    {
        $sites = Site::all()
            ->where('published', true)
            ->select('id', 'site_name')
            ->toArray();

        return view('site.map', ['sites' => $sites]);
    }
}
