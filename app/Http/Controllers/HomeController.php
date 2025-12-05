<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $randomSite = Site::inRandomOrder()->first();
        return view('welcome', compact('randomSite'));
    }

    public function dashboard()
    {
        $user = Auth::user();

        $userFavourites = $user->favourites;
        $numSites = 3;

        if (!isset($_COOKIE['lat']) || !isset($_COOKIE['lng'])) {
            $curLat = 53.59476;
            $curLng = -2.56092;
        } else {
            $curLat = $_COOKIE['lat'];
            $curLng = $_COOKIE['lng'];
        }

        $localSites = Site::select(DB::raw("id, site_name, site_description, near, site_access, w3w, begin, end, lat, lng, updated_at, `from`, `to`, ST_Distance_Sphere(point(lat, lng), point($curLat,$curLng))/1000 as distance_km"))
            ->orderBy('distance_km', 'asc')
            ->limit($numSites)
            ->get()
            ->toArray();

        $allSites = Site::select(DB::raw("id, site_name, site_description, begin, end, lat, lng, `from`, `to`, ROUND(ST_Distance_Sphere(point(lat, lng), point($curLat,$curLng))/1000) as distance_km"))
            ->orderBy('distance_km', 'asc')
            ->get()
            ->toArray();

//        dd($localSites);
        return view('dashboard', compact('localSites', 'curLat', 'curLng', 'allSites', 'userFavourites'));
    }

    public function nearest()
    {
        $directions = ["N", "NNE", "NE", "ENE", "E", "ESE", "SE", "SSE", "S", "SSW", "SW", "WSW", "W", "WNW", "NW", "NNW", "N"];

        if (!isset($_COOKIE['lat']) || !isset($_COOKIE['lng'])) {
            $curLat = null;
            $curLng = null;
        } else {
            $curLat = $_COOKIE['lat'];
            $curLng = $_COOKIE['lng'];
        }

        $nearestSite = DB::table('sites')
            ->selectRaw("sites.id, forecasts.data,  ST_Distance_Sphere(point(lat, lng), point($curLat,$curLng))/1000 as distance_km")
            ->leftJoin('forecasts', 'sites.id', '=', 'forecasts.site_id')
            ->orderBy('distance_km', 'asc')
            ->first();

        $siteID = $nearestSite->id;
        $json = $nearestSite->data;

        $data = json_decode($json);
        $current = $data->current;
        setcookie("nearestSiteID", $siteID);

        $wind_deg = $current->wind_deg;
        $windIndex = (int) (($wind_deg * 16 / 360) + 0.5);
        $wind_dir = $directions[$windIndex];

        $sitesForDirection = DB::table("site_wind_directions")
            ->selectRaw("sites.*, forecasts.*, ST_Distance_Sphere(point(lat, lng), point($curLat,$curLng))/1000 as distance_km")
            ->leftJoin("sites", "site_wind_directions.siteID", "=", "sites.id")
            ->leftJoin('forecasts', 'sites.id', '=', 'forecasts.site_id')
            ->where("direction", $windIndex)
            ->orderBy('distance_km', 'asc')
            ->limit(10)
            ->get()
        ->toArray();

        return view('site.nearest', ['current' => $current, 'directions' => $directions, 'sites' => $sitesForDirection]);
    }
}
