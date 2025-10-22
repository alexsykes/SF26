<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Support\Facades\DB;

class SiteController extends Controller
{
    public function index($id)
    {
        $site = Site::where('id', $id)->first();

//        dd($forecast);
        return view('site.detail', compact('site'));
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

        return view('site.list', compact('sites'));
    }
}
