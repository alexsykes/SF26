<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $gmap = config('gmap');

        if (!isset($_COOKIE['lat']) || !isset($_COOKIE['lng'])) {
            $curLat = null;
            $curLng = null;
        } else {
            $curLat = $_COOKIE['lat'];
            $curLng = $_COOKIE['lng'];
        }

        $randomSite = Site::inRandomOrder()->first();

        return view('welcome', compact('randomSite', 'curLat', 'curLng'));
    }

    public function dashboard()
    {
        $gmap = config('gmap');
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
        return view('dashboard', compact('localSites', 'curLat', 'curLng', 'allSites'));
    }
}
