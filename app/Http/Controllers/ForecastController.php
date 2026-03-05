<?php

namespace App\Http\Controllers;

use App\Models\Forecast;
use App\Models\Site;

class ForecastController extends Controller
{
    public function index($id)
    {
        $site = Site::where('id', $id)->first();
        if ($site == null) {
            info("Site Not Found id: $id");
            abort(404);
        } else {
            $forecast = Forecast::where('site_id', $site->id)->first();
            if ($forecast) {
                return view('site.forecast', compact('site', 'forecast'));
            } else {
                info("Forecast for site Not Found - siteID: $id");
                abort(404);
            }
        }
        //        dd($forecast);
    }
}
