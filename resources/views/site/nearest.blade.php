@php

    $sitesHTML="";
        $msg = "A list of local sites for the forecast wind direction for your location are listed below.";

@endphp


<x-app-layout>
    <script>
        function directionChanged() {
            let directionForm = document.getElementById('directionForm');
            let windDirection = document.getElementById('windDirection');
            let direction = windDirection.value;
            document.cookie = "dir=" + direction;
            console.log("Direction changed: " + direction);
            directionForm.submit();

            // this.form.submit();
        }
    </script>
    <script>

        // https://stackoverflow.com/questions/24952593/how-to-add-my-location-button-in-google-maps
        function addYourLocationButton(map) {
            var controlDiv = document.createElement('div');

            var firstChild = document.createElement('button');
            firstChild.style.backgroundColor = '#fff';
            firstChild.style.border = 'none';
            firstChild.style.outline = 'none';
            firstChild.style.width = '40px';
            firstChild.style.height = '40px';
            firstChild.style.borderRadius = '2px';
            firstChild.style.boxShadow = '0 1px 4px rgba(0,0,0,0.3)';
            firstChild.style.cursor = 'pointer';
            firstChild.style.marginRight = '10px';
            firstChild.style.padding = '0px';
            firstChild.title = 'Your Location';
            controlDiv.appendChild(firstChild);

            var secondChild = document.createElement('div');
            secondChild.style.margin = '10px';
            secondChild.style.width = '18px';
            secondChild.style.height = '18px';
            secondChild.style.backgroundImage = 'url(https://maps.gstatic.com/tactile/mylocation/mylocation-sprite-1x.png)';
            secondChild.style.backgroundSize = '180px 18px';
            secondChild.style.backgroundPosition = '0px 0px';
            secondChild.style.backgroundRepeat = 'no-repeat';
            secondChild.id = 'you_location_img';
            firstChild.appendChild(secondChild);

            // google.maps.event.addListener(map, 'dragend', function () {
            //     $('#you_location_img').css('background-position', '0px 0px');
            // });

            firstChild.addEventListener('click', function () {
                var imgX = '0';
                var animationInterval = setInterval(function () {
                    if (imgX == '-18') imgX = '0';
                    else imgX = '-18';
                    // $('#you_location_img').css('background-position', imgX + 'px 0px');
                }, 500);
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

                        map.setCenter(latlng);
                        clearInterval(animationInterval);
                    });
                } else {
                    clearInterval(animationInterval);
                }
            });
            controlDiv.index = 1;
            map.controls[google.maps.ControlPosition.RIGHT_TOP].push(controlDiv);
        }

        function getCookieByName(name) {
            const cookies = document.cookie.split('; ');
            for (let cookie of cookies) {
                const [cookieName, cookieValue] = cookie.split('=');
                if (cookieName === name) {
                    return cookieValue;
                }
            }
            return null; // Return null if the cookie is not found
        }


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
            const {AdvancedMarkerElement} = await google.maps.importLibrary("marker");
            const {Map} = (await google.maps.importLibrary('maps'));

            let lat = 53.67;
            let lng = -1.92;
            let zoom = 6;

            // Get saved map
            let curLat = getCookieByName('curLat');
            let curLng = getCookieByName('curLng');
            let curZoom = getCookieByName('curZoom');

            if (curLat) (lat = curLat);
            if (curLng) (lng = curLng);
            if (curZoom) (zoom = curZoom);

            initialLocation = new google.maps.LatLng(lat, lng);

            map = new Map(document.getElementById("map"), {
                center: initialLocation,
                zoom: parseInt(zoom),
                streetViewControl: false,
                mapTypeControl: false,
                mapTypeId: google.maps.MapTypeId.TERRAIN,
                mapId: "c2290875eac93973",
            });

            map.setCenter(initialLocation);

            let curCenter = map.get('center');
            console.log("Centre: " + curCenter);
            curZoom = map.get('zoom');
            console.log("Zoom: " + curZoom);

            // Start of foreach
            <?php
//            dd($sites);
            foreach ($sites as $siteForMap) {
//                dd($siteForMap);
                $url = env('APP_URL');
                $url .= "/site/detail/" . $siteForMap->id;
                ?>

                infowindow = new google.maps.InfoWindow({
                content: "{{$siteForMap->site_name}}",
                ariaLabel: "{{$siteForMap->site_name}}",
            });


            map.addListener("zoom_changed", () => {
                const d = new Date();
                d.setTime(d.getTime() + (365 * 24 * 60 * 60 * 1000));
                let expires = "expires=" + d.toUTCString();

                let curZoom = map.getZoom();
                document.cookie = "curZoom=" + curZoom + ";" + expires + ";path=/";
            });
            map.addListener("center_changed", () => {
                const d = new Date();
                d.setTime(d.getTime() + (365 * 24 * 60 * 60 * 1000));
                let expires = "expires=" + d.toUTCString();

                let curLat = map.get('center').lat();
                let curLng = map.get('center').lng();

                document.cookie = "curLat=" + curLat + ";" + expires + ";path=/";
                document.cookie = "curLng=" + curLng + ";" + expires + ";path=/";
            });

            marker = new AdvancedMarkerElement({
                map,
                position: {lat: {{$siteForMap->lat}}, lng: {{$siteForMap->lng}}},
                title: "{{$siteForMap->site_name}}",
            });
            {{--console.log("SiteID: " + {{$siteForMap['id']}});--}}
            marker.addListener("click", () => {

                let html = "<a href=\"{{$url}}\"><b>{{$siteForMap->site_name}}</b> ({{$siteForMap->begin}} to {{$siteForMap->end}})"
                html += " - Click for full details click<a href=$url"
                let messageDiv = document.getElementById('messageDiv');
                messageDiv.innerHTML = html;

            });
            // End of foreach
            <?php } ?>


            addYourLocationButton(map);
        }

        initMap();

    </script>
    <x-slot name="header">
        <div class="flex items-start justify-between"><h2
                    class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">
                {{ __('Nearest sites for ') }}{{$wind_dir}}
            </h2>
            <form id="directionForm" method="post" action="/nearest">
                @csrf
                @method('PUT')
                <select class="" id="windDirection" name="windDirection"
                        onchange="directionChanged()">
                    @foreach($directions as $direction)
                        <option value="{{$direction}}"
                                @php
                                    if($direction == $wind_dir) {
                                        echo " selected ";
                                    }
                                @endphp

                        >{{$direction}}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
        {{--        <div class="text-sm">{{$msg}}</div>--}}
        <div class="text-sm">For full details and the latest forecast for these sites, click on the site
            name. For current wind conditions, click on Windy.com
        </div>
        <div class="text-sm">Distances are measured from the centre of the map when the page was loaded.
        </div>
    </x-slot>
    <div id="mapContainer" class="h-64 sm:h-[32rem]">
        <div class="map100" id="map">Map should appear here</div>
    </div>
    <div id="messageDiv" class="bg-white ml-4 mr-4 p-2"><b>Marker click</b> Site link will appear here…</div>
    <div class="visible p-2  bg-white shadow-xl flex mt-4 ml-4 mr-4 h-full flex-1 flex-col gap-1 rounded-xl border border-neutral-200">
        @foreach($sites as $site)
            {{--            @dump($site)--}}
            @php
                $siteID = $site->site_id;
                $site_name = $site->site_name;
//                $site_dirs = "";
                $distance_km = "";
                $link = "/site/detail/$siteID";

                $begin = $site->begin;
                $end = $site->end;

                $lat = $site->lat;
                $lng = $site->lng;
                $distance_km = intval($site->distance_km);
                $site_dirs = $begin . " - ". $end;

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