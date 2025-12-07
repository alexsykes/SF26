<?php

$img = Storage::url('images/OpenWeather-Master-Logo RGB.png');

?>
<div class="flex items-center align-middle m-4 text-center text-sm justify-center">
    {{--    <div class="">About</div>--}}
    <div class=""><img width="80" src="{{$img}}"></div>
    <div class=""><a href="https://OpenWeatherMap.org">Weather data provided by OpenWeather</a></div>
</div>
