<?php

namespace App\Http\Controllers;

use App\Models\Forecast;
use App\Models\Site;

class ForecastController extends Controller
{
    public function index($id)
    {
        $site = Site::where('id', $id)->first();
        $forecast = Forecast::where('site_id', $site->id)->first();

//        dd($forecast);
        return view('site.forecast', compact('site', 'forecast'));
    }
}
