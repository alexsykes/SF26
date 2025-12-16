@php
    //    dd($sitesForDirection);
    //            $wind_speed = $current->wind_speed;
    //            $wind_deg = $current->wind_deg;
    //
    //            $windIndex = (int) (($wind_deg * 16 / 360) + 0.5);
    //            $wind_dir = $directions[$windIndex];
    //
    //            if($windIndex == 16) {
    //                $windIndex = 0;
    //            }
    //
    //            $sitesHTML="";

    //        dump($windIndex, $site_winds);
    //            if(in_array($windIndex, $site_winds)) {
    //                $msg = "The nearest site to your recorded location is $nearestSite->site_name. A list of local sites for the current wind direction are listed below.";
    //            } else {
    //                $msg  = "The nearest site to your recorded location is $nearestSite->site_name. Current forecast conditions suggest that this site will not be working today. Alternative sites for the current wind direction are listed below.";
    //            }
@endphp
<x-app-layout>
    <x-slot name="header">

        <div class="flex items-start justify-between"><h2
                    class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">
                {{--                {{ __('Nearest sites for ') }}{{$wind_dir}}--}}
            </h2>
            <form method="post" action="/sites/direction">
                @csrf
                @method('PUT')
                <select name="windDirection" onchange="this.form.submit()">

                    @foreach($directions as $direction)
                        <option value="{{$direction}}">{{$direction}}</option>
                    @endforeach
                </select></form>
        </div>
        {{--        <div class="text-sm">{{$msg}}</div>--}}
        <div class="text-sm">To get the latest forecast for these sites, click on the site
            name. For current wind conditions, click on Windy.com
        </div>
    </x-slot>


    <div class="visible p-2  bg-white shadow-xl flex mt-4 ml-4 mr-4 h-full flex-1 flex-col gap-1 rounded-xl border border-neutral-200">
        @foreach($sitesForDirection as $site)
            {{--            @dump($site)--}}
            @php
                $siteID = $site->site_id;
                $site_name = $site->site_name;
                $site_dirs = "$site->begin - $site->end";
                $distance_km = intval($site->distance_km);
                $link = "/site/detail/$siteID";

                $lat = $site->lat;
                $lng = $site->lng;

                $windy_url = "https://www.windy.com/?".$lat.",".$lng.",14";
            @endphp

            <div class="flex flex-col-2  justify-between bg-white">

                <div class="col-span-1"><a href="{{$link}}">
                        <b>{{$site_name}}</b>&nbsp; ({{$site_dirs}}) - {{$distance_km}} km
                    </a>
                </div>
                <div class="col-span-1 text-end pr-2">
                    <a class="underline" target="_blank" href="{{$windy_url}}">Windy.com</a>
                </div>
            </div>
        @endforeach
        {{--        @dd($sites)--}}
    </div>

</x-app-layout>