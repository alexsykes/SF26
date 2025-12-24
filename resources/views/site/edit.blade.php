<x-admin>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">{{$site->site_name}}</h2>
    </x-slot>
    <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-AtLvoAbjtcSN2sPXAT5HHkgk97UOOVY&libraries=maps,marker"
            defer
    ></script>
    <gmp-map
            center="{{$site->lat}},{{$site->lng}}"
            zoom="14"
            map-id="aa9cce9d23deaacd767a5d9d"
            style="height: 500px"></gmp-map>
    <form method="POST" action="/site/update">
        @csrf
        @method('PATCH')
        <input type="hidden" name="siteID" value="{{$site->id}}">
        <div class="visible  bg-white shadow-xl flex mt-4 ml-4 mr-4 h-full flex-1 flex-col gap-1 rounded-xl border border-neutral-200 ">

            <table class="table-auto">
                <thead>
                <tr>
                    <th>From</th>
                    <th>Comments</th>
                    <th class="text-center">Completed</th>
                </tr>
                </thead>

                <tbody class="p-0">
                @foreach($suggestions as $suggestion)
                    <input type="hidden" name="suggestionIDs[]" value="{{$suggestion->id}}">
                    <tr class=" odd:bg-gray-100">
                        <td class="pl-2">{{$suggestion->name}}</td>
                        <td class="pr-2">{{$suggestion->suggestion}}</td>
                        <td><input type="checkbox" name="completed[]" class="text-center" value="{{$suggestion->id}}">
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

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
                                       value="{{ $site->site_name }}"
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
                                   value="{{ $site->near }}"
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
                                       value="{{ $site->w3w }}"
                                       id="w3w"
                                       placeholder="fingers.ruin.flights">
                            </div>
                        </div>
                        @error('w3w')
                        <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="latInput" class="block  font-semibold ">Latitude</label>
                        <div class="mt-2">
                            <div>
                                <input type="text"
                                       name="latInput"
                                       value="{{ $site->lat }}"
                                       id="latInput">
                            </div>
                        </div>
                        @error('latInput')
                        <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="lngInput" class="block  font-semibold ">Longitude</label>
                        <div class="mt-2">
                            <div>
                                <input type="text"
                                       name="lngInput"
                                       value="{{ $site->lng }}"
                                       id="lngInput">
                            </div>
                        </div>
                        @error('lngInput')
                        <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-full">
                        <label for="site_description" class="block  font-semibold ">About</label>
                        <div class="mt-2">
                                <textarea name="site_description"
                                          id="site_description"
                                          rows="3"
                                          class="block w-full rounded-md bg-white px-3 py-1.5 text-base  outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:"
                                          placeholder="Please give information about the site.">{{ $site->site_description }}</textarea>
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
                          class="block w-full rounded-md bg-white px-3 py-1.5 text-base  outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:"
                          placeholder="Please give information about how to access the site and any special rules or restrictions.">{{ $site->site_access  }}</textarea>
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

                    {{--                    <div class="grid sm:col-span-full">--}}
                    <div class="">
                        <label for="from" class="block text-sm/10 font-semibold">From:</label>
                        <select class="ml-0  bg-white pb-2 space-x-4 sm:col-span-2" name="from"
                                id="from">
                            @php
                                $from = $site->from;
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
                    <div class="">
                        <label for="to" class="block text-sm/10 font-semibold">To:</label>
                        <select class="ml-0   bg-white pb-2 space-x-4 sm:col-span-2" name="to"
                                id="to">
                            @php
                                $to = $site->to;
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
                        {{--                        </div>--}}
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
    <script>document.addEventListener('DOMContentLoaded', function () {
            // var curlatLng = new google.maps.LatLng(-29.3456, 151.4346)

            console.log("loaded");
            const mapElement = document.querySelector('gmp-map');
            const map = mapElement.innerMap;
            console.log(mapElement);

            let mapCentre = new google.maps.LatLng({{$site->lat}}, {{$site->lng}});

            map.setOptions({
                mapId: 'aa9cce9d23deaacd767a5d9d',
                center: mapCentre,
                zoomControl: true,
                cameraControl: false,
                mapTypeControl: false,
                scaleControl: true,
                streetViewControl: false,
                rotateControl: false,
                fullscreenControl: true,
                mapTypeId: google.maps.MapTypeId.TERRAIN,
                zoom: 12,
            });

            map.addListener("center_changed", () => {
            });

            const marker = new google.maps.marker.AdvancedMarkerElement({
                position: mapCentre,
                map,
                title: "Drag to launch point",
                gmpDraggable: true,
            })

            // Add listener for marker drag
            marker.addListener('dragend', (event) => {
                // Save initial marker position as cookie values
                const d = new Date();
                d.setTime(d.getTime() + (365 * 24 * 60 * 60 * 1000));
                let expires = "expires=" + d.toUTCString();

                const position = marker.position;


                console.log("Drag ended");
                markerLat = position.lat.toFixed(6);
                markerLng = position.lng.toFixed(6);
                let latInput = document.getElementById("latInput");
                let lngInput = document.getElementById("lngInput");

                latInput.setAttribute('value', markerLat);
                lngInput.setAttribute('value', markerLng);

                document.cookie = "markerLat=" + markerLat + ";" + expires + ";path=/";
                document.cookie = "markerLng=" + markerLng + ";" + expires + ";path=/";
            });

        });
    </script>


</x-admin>