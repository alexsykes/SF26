<?php

use App\Models\Forecast;
use App\Models\Site;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::command('backup:run')->dailyAt('02:01');

Artisan::command('getForecast', function () {

    $sites = Site::all();
//    $sites = Site::limit(5)->get();
//    dd($sites);
    $open_weather = Config::get('app.OPEN_WEATHER');
    $count = 0;

    foreach($sites as $site) {
        $lat = $site->lat;
        $lng = $site->lng;
        $url = "https://api.openweathermap.org/data/3.0/onecall?lat=$lat&lon=$lng&exclude=minutely,alerts&units=imperial&appid=".$open_weather;

        if (!$site->forecast) {
            $rawData = (file_get_contents($url, 'r'));
            Forecast::create([
                'site_id' => $site->id,
                'data' => $rawData,
                'version' => 1,
                'updated_at' => NOW(),
            ]);
        } else {
            $forecast = $site->forecast;
            $version = $forecast->version + 1;
            $rawData = (file_get_contents($url, 'r'));

            $forecast->update([
                'data' => $rawData,
                'updated_at' => NOW(),
                'version' => $version,
            ]);
            $count++;
        }
    }
//    info("$count forecasts updated.");
})->twiceDailyAt(5, 13, 57);

Artisan::command('UpdateWindDirections', function () {

    $directions = array("N", "NNE", "NE", "ENE", "E", "ESE", "SE", "SSE", "S", "SSW", "SW", "WSW", "W", "WNW", "NW", "NNW");

    $numDirs = count($directions);

    $sites = Site::all();
    foreach ($sites as $site) {
//    $site = $sites->first();
        $site_name = $site->site_name;
        $begin = $site->begin;
        $end = $site->end;
        $siteID = $site->id;

        $beginIndex = array_search($begin, $directions);
        $endIndex = array_search($end, $directions);

//    Working
        if($endIndex > $beginIndex) {
            for($i = $beginIndex; $i <= $endIndex; $i++) {
                $site_wind_direction = \App\Models\SiteWindDirections::create([
                    'siteID' => $siteID,
                    'direction' => $i,
                ]);
            }
        }
        elseif ($endIndex == $beginIndex) {
            $site_wind_direction = \App\Models\SiteWindDirections::create([
                'siteID' => $siteID,
                'direction' => $endIndex,
            ]);
        }
        else {
            for($i = $beginIndex; $i < $numDirs; $i++) {
                $site_wind_direction = \App\Models\SiteWindDirections::create([
                    'siteID' => $siteID,
                    'direction' => $i,
                ]);
            }
            for($i = 0; $i <= $endIndex; $i++) {
                $site_wind_direction = \App\Models\SiteWindDirections::create([
                    'siteID' => $siteID,
                    'direction' => $i,
                ]);
            }
        }


    }

});