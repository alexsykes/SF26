<x-app-layout>
    <style>
        .text-center {
            text-align: center;
        }

        #map {
            width: 100%;
            height: 100vh;
        }
    </style>
    <script>
        (g => {
            var h, a, k, p = " {{config('gmap.gmap_key')}}", c = "google", l = "importLibrary", q = "__ib__",
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
            key: " {{config('gmap.gmap_key')}}",
            v: "weekly",
            // Use the 'v' parameter to indicate the version to use (weekly, beta, alpha, etc.).
            // Add other bootstrap parameters as needed, using camel case.
        });


        let map, activeInfoWindow, markers = [];
        const MAP_BOUNDS =
            {
                north: 70,
                south: -70,
                west: -160,
                east: 160
            }

        async function initMap() {
            const {Map} = await google.maps.importLibrary("maps");
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
                restriction: {
                    latLngBounds:
                    MAP_BOUNDS,
                    strictBounds: false,
                },
                zoom: parseInt(zoom),
                streetViewControl: false,
                mapTypeControl: false,
                mapTypeId: google.maps.MapTypeId.TERRAIN,
                mapId: "c2290875eac93973",
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

            initMarkers();
            addYourLocationButton(map);

            function initMarkers() {
                const initialMarkers = <?php echo json_encode($sites); ?>;

                for (let index = 0; index < initialMarkers.length; index++) {
                    const markerData = initialMarkers[index];
                    const siteURL = "<?php echo config('app.url'); ?>" + "/site/detail/" + markerData.id;
                    // console.log(siteURL);
                    const headerContent = markerData.site_name + ' ('
                        + markerData.begin + ' - '
                        + markerData.end
                        + ')';
                    const contentString = '<div>' + markerData.site_description + '</div>'
                        + '<div><a class="font-semibold pt-4 underline" href="' + siteURL + '">Click here for full details</a></div>'

                    ;
                    const marker = new google.maps.Marker({
                        position: {lat: parseFloat(markerData['lat']), lng: parseFloat(markerData['lng'])},
                        draggable: false,
                        map
                    });
                    markers.push(marker);

                    const infowindow = new google.maps.InfoWindow({
                        label: 'Title',
                        content: contentString,
                        headerContent: headerContent,
                    });
                    marker.addListener("click", (event) => {
                        if (activeInfoWindow) {
                            activeInfoWindow.close();
                        }
                        infowindow.open({
                            anchor: marker,
                            shouldFocus: false,
                            map
                        });
                        activeInfoWindow = infowindow;
                        // markerClicked(marker, index);
                    });
                }
            }
        }

        initMap();
    </script>
    <x-slot name="header">
        <div class="flex items-start justify-between"><h2
                    class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">
                SlopeFinder UK
            </h2>
            <form name="directionForm" id="directionForm" method="post" action="/sitemap">
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

    </x-slot>
    <div id="map"></div>
</x-app-layout>