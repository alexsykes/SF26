{{--@dd($sitesForMap)--}}
@php
    $numSites = sizeof($sites);
    $userFavouritesArray = explode(',', $favourites);

    $sitesHTML = "";
    foreach($sites as $site) {
        $site_name = $site['site_name'];
        $site_distance = $site['distance_km'];
        $begin = $site['begin'];
        $end = $site['end'];
        $siteID = $site['id'];

            $fav = "";
            if(in_array($siteID, $userFavouritesArray)) {
                $fav = " <span><i class=\"text-teal-400 fa-solid fa-heart\"></i></span>";
            }

           $sitesHTML .= "<a href=\"/site/detail/{$siteID}\"><div class=\" grid grid-cols-4 w-full\">
           <div class=\"col-span-3\">$fav <b> $site_name</b>  ($begin - $end) </div>";
           $sitesHTML .= "<div class=\"col-span-1 text-end\"> $site_distance km</div></div></a>";

}
//    dd($sitesHTML);

// Check for cookies

@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            Sites - A to Z
        </h2>
        <div class="text-sm">For full details and the latest forecast for these sites, click on the site
            name.
        </div>
        <div class="font-semibold text-sm">Distances are measured from the centre of the map when the map was last
            loaded.
        </div>
    </x-slot>

    {{--    <div id="mapContainer" class="h-64 sm:h-[32rem]">--}}
    {{--        <div class="map100" id="map">Map should appear here</div>--}}
    {{--    </div>--}}

    {{--    <div id="messageDiv" class="bg-white ml-4 mr-4 p-2"><b>Marker click</b> Site link will appear here…</div>--}}
    <div class="visible p-2  bg-white shadow-xl flex mt-4 ml-4 mr-4 h-full flex-1 flex-col gap-1 rounded-xl border border-neutral-200 md:hidden">

        @foreach($sites as $site)
            @php
                $siteID = $site['id'];
                $link = "/site/detail/$siteID";
            @endphp
            <a href="{{$link}}">
                <div class="pl-2 grid grid-cols-4">
                    <div class="col-span-3">
                        @if(in_array($siteID, $userFavouritesArray))
                            <span>
                <i class="text-teal-400 fa-solid fa-heart"></i></span>
                        @endif
                        <b>{{$site['site_name']}}</b>&nbsp; ({{$site['begin']}} - {{$site['end']}})
                    </div>
                    <div class="col-span-1 text-end pr-2">
                        {{$site['distance_km']}} km
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    {{-- Wide screen version - TODO prevent line break before wind directions--}}
    <div class="hidden flex h-full w-full flex-1 flex-col gap-4 rounded-xl p-4 md:p-4 md:block">
        <div class="bg-white shadow-xl grid auto-rows-min gap-4 ">

            <div class="overflow-hidden  border-neutral-200 dark:border-neutral-700">
                <div class="p-4  three  md:one">
                    <?php echo $sitesHTML; ?>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>