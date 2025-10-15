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

        if (!isset($_COOKIE['lat']) || !isset($_COOKIE['lng'])) {
            $curLat = 53.59476;
            $curLng = -2.56092;
        } else {
            $curLat = $_COOKIE['lat'];
            $curLng = $_COOKIE['lng'];
        }

        $sites = Site::select(DB::raw("site_name, site_description, begin, end, lat, lng, `from`, `to`, ST_Distance_Sphere(point(lat, lng), point($curLat,$curLng))/1000 as distance_km"))
            ->orderBy('distance_km', 'asc')
            ->limit(3)
            ->get()
            ->toArray();

//        dd($sites);
        return view('dashboard', compact('sites', 'curLat', 'curLng'));
    }
}
