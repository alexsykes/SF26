@php
//dd($sites);
    $wind_speed = $current->wind_speed;
    $wind_deg = $current->wind_deg;
    $wind_gust = $current->wind_gust;

    $windIndex = (int) (($wind_deg * 16 / 360) + 0.5);
    $wind_dir = $directions[$windIndex];

    $windSpeeds = intval($wind_speed)." ~ ".intval($wind_gust);

    $sitesHTML="";

@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">
            {{ __('Nearest sites for ') }}{{$wind_dir}}
        </h2>
    </x-slot>


    <div class="visible p-2  bg-white shadow-xl flex mt-4 ml-4 mr-4 h-full flex-1 flex-col gap-1 rounded-xl border border-neutral-200">
        @foreach($sites as $site)
{{--            @dump($site)--}}
            @php
                $siteID = $site->site_id;
                $site_name = $site->site_name;
                $site_dirs = "$site->begin - $site->end";
                $distance_km = intval($site->distance_km);
                $link = "/site/detail/$siteID";
            @endphp
            <a href="{{$link}}">
                <div class="pl-2 grid grid-cols-4">
                    <div class="col-span-3">
{{--                        @if(in_array($siteID, $userFavouritesArray))--}}
{{--                            <span>--}}
{{--                <i class="text-teal-400 fa-solid fa-heart"></i></span>--}}
{{--                        @endif--}}
                        <b>{{$site_name}}</b>&nbsp; ({{$site_dirs}})
                    </div>
                    <div class="col-span-1 text-end pr-2">
                        {{$distance_km}} km
                    </div>
                </div>
            </a>
        @endforeach
{{--        @dd($sites)--}}
    </div>

</x-app-layout>