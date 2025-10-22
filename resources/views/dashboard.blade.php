<x-app-layout>
    @php
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



           $sitesHTML .= "<a href=\"/site/detail/{$siteID}\"><div class=\" grid grid-cols-4 w-full\">
           <div class=\"col-span-3\"><b>$site_name</b> ($begin - $end) </div>";
           $sitesHTML .= "<div class=\"col-span-1 text-end\"> $site_distance km</div></div></a>";
//
//           $sitesHTML .= "<div class=\" grid grid-cols-2 w-full\"> <div class=\"\"><b>$site_name</b> ($begin - $end) </div>";
//           $sitesHTML .= "<div class=\" text-end\"> $site_distance km</div></div>";
        }
//    dd($sitesHTML);
    @endphp
    <script>
        var localSites = <?php echo json_encode($localSites); ?>;

        (g => {
            var h, a, k, p = "The Google Maps JavaScript API", c = "google", l = "importLibrary", q = "__ib__",
                m = document, b = window;
            b = b[c] || (b[c] = {});
            var d = b.maps || (b.maps = {}), r = new Set, e = new URLSearchParams,
                u = () => h || (h = new Promise(async (f, n) => {
                    await (a = m.createElement("script"));
                    e.set("libraries", [...r] + "");
                    for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]);
                    e.set("callback", c + ".maps." + q);
                    a.src = `https://maps.${c}apis.com/maps/api/js?` + e;
                    d[q] = f;
                    a.onerror = () => h = n(Error(p + " could not load."));
                    a.nonce = m.querySelector("script[nonce]")?.nonce || "";
                    m.head.append(a)
                }));
            d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(() => d[l](f, ...n))
        })({
            key: "{{config('gmap.gmap_key')}}",
            v: "weekly",
            // Use the 'v' parameter to indicate the version to use (weekly, beta, alpha, etc.).
            // Add other bootstrap parameters as needed, using camel case.
        });


        let map;

        async function initMap(i, site) {
            // console.log(i);
            const {Map} = await google.maps.importLibrary("maps");
            const {AdvancedMarkerElement} = await google.maps.importLibrary("marker");

            map = new Map(document.getElementById("map" + i), {
                center: {lat: parseFloat(site['lat']), lng: parseFloat(site['lng'])},
                zoom: 12,
                streetViewControl: false,
                mapTypeControl: false,
                mapTypeId: google.maps.MapTypeId.TERRAIN,
                mapId: "c2290875eac93973",
            });
            const marker = new AdvancedMarkerElement({
                map,
                position: {lat: parseFloat(site['lat']), lng: parseFloat(site['lng'])},
            });
        }


        for (i = 0; i < {{$numLocalSites}}; i++) {
            site = localSites[i];
            lat = site['lat'];
            lng = site['lng'];
            initMap(i, site);
        }
    </script>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">
            {{ __('Local sites') }}
        </h2>
    </x-slot>

    {{-- Maps start   --}}
    <div class="flex  h-full w-full flex-1 flex-col gap-4 rounded-xl p-4 md:p-4">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            @php
                $numSites = sizeof($localSites);
                    for ($i = 0; $i < $numSites; $i++) {
                    $site = $localSites[$i];
                    $begin = $site['begin'];
                    $end = $site['end'];
                    $dirs = $begin." to ".$end;
                    $lat = $site['lat'];
                    $lng = $site['lat'];
                    $siteID = $site['id'];

        $url = "https://www.windy.com/$lat,$lng,14";
            @endphp
            <div class="bg-white map shadow-xl relative aspect-4/3 overflow-hidden rounded-xl border border-neutral-200
                    dark:border-neutral-700">
                <div id="map{{$i}}" class="bg-slate-500 w-full aspect-square"></div>
                <div class="font-semibold  bg-white p-2 pb-0 ">{{$site['site_name']}}</div>
                <div class="p-2 pt-0  bg-white ">{{$site['site_description']}}</div>
                <div class="p-2  bg-white ">Winds: {{$dirs}}</div>
                {{--                <h1 class="mb-1 font-medium">Winds</h1>--}}
                {{--                <p class="mb-2 text-[#706f6c] dark:text-[#A1A09A]">{{$site['begin']}} to {{$site['end']}}</p>--}}
                {{--                <h1 class="mb-1 font-medium">Locality</h1>--}}
                {{--                <p class="mb-2 text-[#706f6c] dark:text-[#A1A09A]">{{$site['near']}}</p>--}}
                {{--                <h1 class="mb-1 font-medium">Description</h1>--}}
                {{--                <p class="mb-2 text-[#706f6c] dark:text-[#A1A09A]">{{$site['site_description']}}</p>--}}
                {{--                <h1 class="mb-1 font-medium">Access</h1>--}}
                {{--                <p class="mb-2 text-[#706f6c] dark:text-[#A1A09A]">{{$site['site_access']}}</p>--}}

                {{--                <p><strong>Coordinates:</strong> Lat: {{$site['lat']}}° Lng: {{$site['lng'] }}°</p>--}}
                {{--                <p><strong>W3W: </strong><a href="https://what3words.com/{{$site['w3w'] }}">{{$site['w3w']}}</a></p>--}}
                {{--                --}}{{--                <!-- p><strong>Site details last updated:</strong> {{$site['updated_at']->format('M jS, Y') }}</p -->--}}
                {{--                --}}{{--                <p><strong>Weather last updated :</strong> {{$forecast->updated_at->format('M jS, g:ia') }}</p>--}}
                {{--                <p><strong>Current conditions on Windy.com - </strong><a target="_blank" href="{{$url}}">click--}}
                {{--                        here</a>--}}
                <div class="p-2  bg-white ">Full details and forecast - <a href="/site/detail/{{$siteID}}">click
                        here</a>
                </div>
            </div>
            @php
                }
            @endphp
        </div>
    </div>
    {{-- Maps end --}}

    {{--  Small screen  --}}
    <div class="visible bg-white shadow-xl flex ml-4 mr-4 h-full flex-1 flex-col gap-1 rounded-xl border border-neutral-200 md:hidden">
        @foreach($allSites as $site)
            @php
                $siteID = $site['id'];
                $link = "/site/detail/$siteID";
            @endphp
            <a href="{{$link}}">
                <div class="pl-2 grid grid-cols-4">
                    <div class="col-span-3">
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
