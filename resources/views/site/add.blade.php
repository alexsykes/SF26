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



                let lat = document.getElementById("lat");
                let lng = document.getElementById("lng");

                lat.setAttribute('value', position.coords.latitude);
                lng.setAttribute('value', position.coords.longitude);

                map = new Map(document.getElementById("map"), {
                    center: {position},
                    zoom: 18,
                    streetViewControl: false,
                    mapTypeControl: false,
                    mapTypeId: google.maps.MapTypeId.TERRAIN,
                    mapId: "c2290875eac93973",
                });

                map.setCenter(initialLocation);

                const marker = new AdvancedMarkerElement({
                    map,
                    gmpDraggable: true,
                    position: {lat: position.coords.latitude, lng: position.coords.longitude},
                });

                marker.addListener('dragend', (event) => {
                    const position = marker.position;
                    let lat = document.getElementById("lat");
                    let lng = document.getElementById("lng");

                    lat.setAttribute('value', position.lat);
                    lng.setAttribute('value', position.lng);
                });
            });
        }
    }

    initMap();

</script>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">
            Add a new Site
        </h2>
    </x-slot>
    <div id="mapContainer" class="h-64 sm:h-[32rem]">
        <div class="map100" id="map">Map should appear here</div>
    </div>
    <form method="POST" action="/site/add">
        @csrf
        <input type="hidden" id="lng" name="lng">
        <input type="hidden" id="lat" name="lat">

        <div class="visible p-2  bg-white shadow-xl flex mt-4 ml-4 mr-4 h-full flex-1 flex-col gap-1 rounded-xl border border-neutral-200 ">

            <div class="space-y-8">

                {{-- Container --}}
                <div class="mt-2 grid grid-cols-1 gap-x-4 gap-y-2 sm:grid-cols-4">

                    <div class="sm:col-span-4">
                        <label for="site_name" class="block  font-semibold ">Name</label>
                        <div class="mt-2">
                            <div>
                                <input type="text"
                                       name="site_name"
                                       value="New site"
                                       required
                                       id="site_name"
                                       placeholder="Winter Hill">
                            </div>
                        </div>
                        @error('site_name')
                        <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-full">
                        <label for="near" class="block  font-semibold ">Near</label>
                        <div class="mt-2">
                            <input type="text"
                                   name="near"
                                   id="near"
                                   required
                                   value="Somewhere local"
                                   placeholder="Nearest towns, landmarks">
                        </div>
                        @error('near')
                        <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-full">
                        <label for="w3w" class="block  font-semibold ">What3Words</label>
                        <div class="mt-2">
                            <div>
                                <input type="text"
                                       name="w3w"
                                       value="fish.and.chips"
                                       id="w3w"
                                       placeholder="fingers.ruin.flights">
                            </div>
                        </div>
                        @error('w3w')
                        <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-full">
                        <label for="site_description" class="block  font-semibold ">About</label>
                        <div class="mt-2">
                                <textarea name="site_description"
                                          required
                                          id="site_description"
                                          rows="3"
                                          class="block w-full rounded-md bg-white px-3 py-1.5 text-base  outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:"
                                          placeholder="Please give as much information as you can about the site. ">As much information as I can about the site.</textarea>
                        </div>
                    </div>
                    @error('site_description')
                    <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                    @enderror

                    <div class="col-span-full">
                        <label for="site_access" class="block  font-semibold ">Access</label>
                        <div class="mt-2">
                  <textarea
                          name="site_access"
                          id="site_access"
                          rows="3"
                          required

                          class="block w-full rounded-md bg-white px-3 py-1.5 text-base  outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:"
                          placeholder="Please give information about how to access the site and any special rules or restrictions.">Information about how to access the site and any special rules or restrictions.</textarea>
                        </div>

                        @error('site_access')
                        <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-0 sm:col-span-full">
                        <label for="site_wind_directions" class="block  font-semibold ">Site wind directions
                            - From - facing the wind, the furthest to your left that works. To - the furthest to
                            your right that works.</label>
                    </div>

                    <div class="grid sm:col-span-full">
                        <div class="sm:col-span-3">
                            <label for="from" class="block text-sm/10 font-semibold md:col-span-3">From:</label>
                            <select class="ml-2 col-span-1 bg-white pb-2 space-x-4 md:col-span-3" name="from"
                                    id="from">
                                @php
                                    $from = 0;
                                @endphp
                                <option @php if($from == 0 ) echo "selected"; @endphp value="0">North</option>
                                <option @php if($from == 1 ) echo "selected"; @endphp value="1">North Northeast
                                </option>
                                <option @php if($from == 2 ) echo "selected"; @endphp value="2">Northeast</option>
                                <option @php if($from == 3 ) echo "selected"; @endphp value="3">East Northeast
                                </option>
                                <option @php if($from == 4 ) echo "selected"; @endphp value="4">East</option>
                                <option @php if($from == 5 ) echo "selected"; @endphp value="5">East Southeast
                                </option>
                                <option @php if($from == 6 ) echo "selected"; @endphp value="6">Southeast</option>
                                <option @php if($from == 7 ) echo "selected"; @endphp value="7">South Southeast
                                </option>
                                <option @php if($from == 8 ) echo "selected"; @endphp value="8">South</option>
                                <option @php if($from == 9 ) echo "selected"; @endphp value="9">South Southwest
                                </option>
                                <option @php if($from == 10 ) echo "selected"; @endphp value="10">Southwest</option>
                                <option @php if($from == 11 ) echo "selected"; @endphp value="11">West Southwest
                                </option>
                                <option @php if($from == 12 ) echo "selected"; @endphp value="12">West</option>
                                <option @php if($from == 13 ) echo "selected"; @endphp value="13">West Northwest
                                </option>
                                <option @php if($from == 14 ) echo "selected"; @endphp value="14">Northwest</option>
                                <option @php if($from == 15 ) echo "selected"; @endphp value="15">North Northwest
                                </option>
                            </select>
                        </div>
                        <div class="sm:col-span-3">
                            <label for="to" class="block text-sm/10 font-semibold md:col-span-3">To:</label>
                            <select class="ml-2 col-span-1  bg-white pb-2 space-x-4 md:col-span-3" name="to"
                                    id="to">
                                @php
                                    $to = 1;
                                @endphp
                                <option @php if($to == 0 ) echo "selected"; @endphp value="0">North</option>
                                <option @php if($to == 1 ) echo "selected"; @endphp value="1">North Northeast
                                </option>
                                <option @php if($to == 2 ) echo "selected"; @endphp value="2">Northeast</option>
                                <option @php if($to == 3 ) echo "selected"; @endphp value="3">East Northeast
                                </option>
                                <option @php if($to == 4 ) echo "selected"; @endphp value="4">East</option>
                                <option @php if($to == 5 ) echo "selected"; @endphp value="5">East Southeast
                                </option>
                                <option @php if($to == 6 ) echo "selected"; @endphp value="6">Southeast</option>
                                <option @php if($to == 7 ) echo "selected"; @endphp value="7">South Southeast
                                </option>
                                <option @php if($to == 8 ) echo "selected"; @endphp value="8">South</option>
                                <option @php if($to == 9 ) echo "selected"; @endphp value="9">South Southwest
                                </option>
                                <option @php if($to == 10 ) echo "selected"; @endphp value="10">Southwest</option>
                                <option @php if($to == 11 ) echo "selected"; @endphp value="11">West Southwest
                                </option>
                                <option @php if($to == 12 ) echo "selected"; @endphp value="12">West</option>
                                <option @php if($to == 13 ) echo "selected"; @endphp value="13">West Northwest
                                </option>
                                <option @php if($to == 14 ) echo "selected"; @endphp value="14">Northwest</option>
                                <option @php if($to == 15 ) echo "selected"; @endphp value="15">North Northwest
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                {{-- Container ends --}}
            </div>


        </div>
        <div class="p-4  flex space-x-4">
            <button class="border bg-white p-2 pr-4 pl-4 shadow-md hover:bg-gray-200 "
                    onclick="history.back()">Go
                Back
            </button>
            <button type="submit" class="border bg-white  p-2 pr-4 pl-4 shadow-md hover:bg-gray-200 ">
                Submit
            </button>
        </div>
    </form>
</x-app-layout>