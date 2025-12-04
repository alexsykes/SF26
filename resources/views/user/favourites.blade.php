<x-app-layout>
    <script>
        var favourites = <?php echo json_encode($favourites); ?>;
        var numFavourites = favourites.length ? favourites.length : 0;

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


        for (i = 0; i < numFavourites; i++) {
            site = favourites[i];
            lat = site['lat'];
            lng = site['lng'];
            initMap(i, site);
        }
    </script>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">
            {{ __('Favourites') }}
        </h2>

    </x-slot>
    {{-- Maps start   --}}
    <div class="flex   w-5xl  flex-1 flex-col gap-4 rounded-xl p-4 md:p-4">
        <div class="grid auto-rows-min gap-4 ">
            @php
                $i=0;
                foreach ($favourites as $site) {
                $begin = $site->begin;
                $end = $site->end;
                $dirs = $begin." to ".$end;
                $lat = $site->lat;
                $lng = $site->lng;
                $siteID = $site->id;
                $forecastData = $site->data;
                $data = json_decode($forecastData);
                $directions = ["N", "NNE", "NE", "ENE", "E", "ESE", "SE", "SSE", "S", "SSW", "SW", "WSW", "W", "WNW", "NW", "NNW", "N"];
                $dayArray = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];

                $hourly = $data->hourly;
                $daily = $data->daily;

                $today = $daily[0]->summary;
                $tomorrow = $daily[1]->summary;
                $html = "";
                foreach($hourly as $hourData) {
                $time = date("D ga", $hourData->dt);
                $windSpeeds = intval($hourData->wind_speed)." ~ ".intval($hourData->wind_gust);
                $dir = $hourData->wind_deg;

                $windIndex = (int) (($dir * 16 / 360) + 0.5);
                $dir = $directions[$windIndex];

                $html .= "<p><strong>$time</strong> $dir at $windSpeeds mph</p>";
                }

                $url = "https://www.windy.com/?".$lat.",".$lng.",14";
//                $url = "https://www.windy.com/\?$site->lat,$site->lng,14";
            @endphp
            <div class="bg-white map shadow-xl relative aspect-4/3 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                {{--                <div class="font-semibold  bg-white p-2 pb-0 "></div>--}}

                <details>
                    <summary class="flex flex-col-2 font-semibold justify-between bg-white p-2 pb-2">
                        <div class="col-span-1">
                            {{$site->site_name}}
                        </div>
                        <div class="col-span-1 font-semibold"><a class="underline" target="_blank" href="{{$url}}">Windy.com</a></div>
                    </summary>
                    <div id="map{{$i}}" class="bg-slate-500 w-full aspect-video"></div>

                    <div class="pl-2 pt-0  bg-white ">{{$site->site_description}}</div>
                    <div class="pl-2  bg-white ">Winds: {{$dirs}}</div>
{{--                    <div class="pl-2 font-semibold">Current conditions on Windy.com - <a class="underline"--}}
{{--                                                                                         target="_blank"--}}
{{--                                                                                         href="{{$url}}">click--}}
{{--                            here</a></div>--}}
                    <details>

                        <summary class="font-semibold  bg-white pl-2">48 hour forecast</summary>
                        <div class="pl-2  bg-white "><?php echo $html; ?>
                        </div>
                    </details>
                    @auth
                        <div class="pl-2 pt-2 font-semibold">Suggest a site update or correction - <a class="underline"
                                                                                                      href="/site/update_request/{{$site->id}}">click
                                here</a></div>
                    @endauth()
                </details>
            </div>
            @php
                $i++;
                }
            @endphp
        </div>
    </div>
</x-app-layout>