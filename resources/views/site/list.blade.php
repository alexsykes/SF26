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
@endphp
<x-app-layout>
    <script>
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

        async function initMap() {
            // const {Map} = await google.maps.importLibrary("maps");
            const {AdvancedMarkerElement} = await google.maps.importLibrary("marker");
            const {Map} = (await google.maps.importLibrary('maps'));
            // const infoWindow = new InfoWindow();


            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

                    // let lat = document.getElementById("lat");
                    // let lng = document.getElementById("lng");
                    let lat = 53.67;
                    let lng = -1.92;

                    initialLocation = new google.maps.LatLng(lat, lng);
                    // lat.setAttribute('value', position.coords.latitude);
                    // lng.setAttribute('value', position.coords.longitude);

                    map = new Map(document.getElementById("map"), {
                        center: {position},
                        zoom: 6,
                        streetViewControl: false,
                        mapTypeControl: false,
                        mapTypeId: google.maps.MapTypeId.TERRAIN,
                        mapId: "c2290875eac93973",
                    });

                    map.setCenter(initialLocation);

                    // Start of foreach
                    <?php foreach ($sitesForMap as $siteForMap) { ?>
                        infowindow = new google.maps.InfoWindow({
                        content: "{{$siteForMap['site_name']}}",
                        ariaLabel: "{{$siteForMap['site_name']}}",
                    });

                    marker = new AdvancedMarkerElement({
                        map,
                        position: {lat: {{$siteForMap['lat']}}, lng: {{$siteForMap['lng']}}},
                        title: "{{$siteForMap['site_name']}}",
                    });
                    console.log("Position: " + position.coords.latitude);
                    marker.addListener("click", () => {
                        
                        let html = "{{$siteForMap['site_name']}} ({{$siteForMap['begin']}} to {{$siteForMap['end']}})"
                        let messageDiv = document.getElementById('messageDiv');
                        messageDiv.setHTMLUnsafe(html);

                    });
                    // End of foreach
                    <?php } ?>
                });
            }
        }

        initMap();

    </script>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">
            {{ __('Sites (A-Z)') }}
        </h2>

    </x-slot>

    <div id="mapContainer" class="h-64 sm:h-[32rem]">
        <div class="map100" id="map">Map should appear here</div>
    </div>

    <div id="messageDiv"></div>
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