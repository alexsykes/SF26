<?php

use App\Models\GForecast;
use App\Models\Site;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB as DBAlias;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

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

Artisan::command('getGForecast', function () {
    $gweather_key = Config::get('gweather.gweather_key_');
    $sites = Site::all();
    $sites = Site::limit(5)->get();


    $updated = 0;
    $added = 0;
    foreach($sites as $site) {
        $lat = $site->lat;
        $lng = $site->lng;
        $site_id = $site->id;

        $url = "https://weather.googleapis.com/v1/forecast/days:lookup?key=$gweather_key&location.latitude=$lat&location.longitude=$lng&days=2";
        $url = "https://weather.googleapis.com/v1/forecast/days:lookup?key=$gweather_key&location.latitude=$lat&location.longitude=$lng";

        $gforecastCount = GForecast::where('site_id', $site_id)->count();

        if($gforecastCount == 0) {
            info("No gForecast");
            $rawData = (file_get_contents($url, 'r'));
            GForecast::create([
                'site_id' => $site->id,
                'data' => $rawData,
                'version' => 1,
            ]);
            $added++;

        } elseif ($gforecastCount == 1) {
//            info("GForecastCount" . $gforecastCount);
            $gforecast = GForecast::where('site_id', $site_id)->first();
            $version = $gforecast->version + 1;
            $rawData = (file_get_contents($url, 'r'));

            $gforecast->data = $rawData;
            $gforecast->updated_at =  NOW();
            $gforecast->version = $version;
            $gforecast->save() ;
            $updated++;
        }
    }
    info("$updated forecasts updated.");
    info("$added forecasts added.");
    echo("$updated forecasts updated.");
    echo("$added forecasts added.\n");
});

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
    info("$count forecasts updated.");
});
