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