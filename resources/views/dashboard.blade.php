<x-app-layout>
    @php
        $userFavouritesArray = explode(',', $userFavourites);
        $numSites = sizeof($allSites);
        $numLocalSites = sizeof($localSites);
//dump($localSites);
        $sitesHTML = "";
        foreach($allSites as $site) {
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
           <div class=\"col-span-3\">$fav<b> $site_name</b> ($begin - $end) </div>";
           $sitesHTML .= "<div class=\"col-span-1 text-end\"> $site_distance km</div></div></a>";
//
//           $sitesHTML .= "<div class=\" grid grid-cols-2 w-full\"> <div class=\"\"><b>$site_name</b> ($begin - $end) </div>";
//           $sitesHTML .= "<div class=\" text-end\"> $site_distance km</div></div>";
        }
//    dd($sitesHTML);
    @endphp
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Sites (Near to Far)') }}
        </h2>
        <div class="text-sm">For full details and the latest forecast for these sites, click on the site
            name.
        </div>
        <div class="font-semibold text-sm">Distances are measured from the centre of the map when the map was last
            loaded.
        </div>
    </x-slot>

    {{--  Small screen  --}}
    <div class="visible bg-white shadow-xl flex m-4 h-full flex-1 flex-col gap-1 rounded-xl border border-neutral-200 md:hidden">
        @foreach($allSites as $site)
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
        <div class="bg-white shadow-xl grid auto-rows-min gap-4 rounded-xl">

            <div class="overflow-hidden  border-neutral-200 dark:border-neutral-700">
                <div class="p-4  three  md:one">
                    <?php echo $sitesHTML; ?>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
