<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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
}
