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
            const {Map} = await google.maps.importLibrary("maps");
            const {AdvancedMarkerElement} = await google.maps.importLibrary("marker");

            map = new Map(document.getElementById("map"), {
                center: {lat: {{$site->lat}}, lng: {{$site->lng}}},
                zoom: 14,
                streetViewControl: false,
                mapTypeControl: false,
                mapTypeId: google.maps.MapTypeId.TERRAIN,
                mapId: "c2290875eac93973",
            });
            const marker = new AdvancedMarkerElement({
                map,
                position: {lat: {{$site->lat}}, lng: {{$site->lng}}},
            });
        }

        initMap();
    </script>
    @php
        $site_name = $site['site_name'];
        $url = "https://www.windy.com/?$site->lat,$site->lng,14";
    @endphp
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">
            {{ __($site['site_name']) }}
        </h2>
    </x-slot>

    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
    <div class="mt-4 flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
        <div class="bg-white   shadow-2xl">
            <div class="flex max-w-[335px] w-full flex-col-reverse lg:max-w-4xl lg:flex-row">

                {{--  Site description          --}}
                <div class="text-[13px] leading-[20px] flex-1 p-6 pb-12 lg:p-12 bg-white dark:bg-[#161615] dark:text-[#EDEDEC] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-bl-lg rounded-br-lg lg:rounded-tl-lg lg:rounded-br-none">               <div class="mt-3 mb-3 space-y-1 ">
                        <button class="border p-2 pr-4 pl-4 shadow-md hover:bg-gray-200 "
                                onclick="history.back()">Go
                            Back
                        </button>
                    </div>
                    <h1 class="mb-1 font-medium">Winds</h1>
                    <p class="mb-2 text-[#706f6c] dark:text-[#A1A09A]">{{$site->begin}} to {{$site->end}}</p>
                    <h1 class="mb-1 font-medium">Locality</h1>
                    <p class="mb-2 text-[#706f6c] dark:text-[#A1A09A]">{{$site->near}}</p>
                    <h1 class="mb-1 font-medium">Description</h1>
                    <p class="mb-2 text-[#706f6c] dark:text-[#A1A09A]">{{$site->site_description}}</p>
                    <h1 class="mb-1 font-medium">Access</h1>
                    <p class="mb-2 text-[#706f6c] dark:text-[#A1A09A]">{{$site->site_access}}</p>

                    <p><strong>Coordinates:</strong> Lat: {{$site->lat }}° Lng: {{$site->lng }}°</p>
                    <p><strong>W3W: </strong><a href="https://what3words.com/{{$site->w3w }}">{{$site->w3w}}</a></p>
                    <!-- p><strong>Site details last updated:</strong> {{$site->updated_at->format('M jS, Y') }}</p -->
                    {{--                <p><strong>Weather last updated :</strong> {{$forecast->updated_at->format('M jS, g:ia') }}</p>--}}
                    <p><strong>Current conditions on Windy.com - </strong><a target="_blank" href="{{$url}}">click
                            here</a>
                    <p><strong>48 hour forecast - </strong><a href="/forecast/{{$site->id}}">click here</a>
                    </p>
                </div>
                {{--  end of Site description--}}

                {{--   Map         --}}
                <div class="bg-[#fff2f2] dark:bg-[#1D0002] relative lg:-ml-px -mb-px lg:mb-0 rounded-t-lg lg:rounded-t-none lg:rounded-r-lg aspect-[335/376] lg:aspect-auto w-full lg:w-[438px] shrink-0 overflow-hidden">
                    {{-- Laravel Logo --}}
                    {{----}}

                    <div class="map100" id="map"></div>
                    {{--End of map--}}

                </div>
            </div>

        </div>
    </div>

    @if (Route::has('login'))
        <div class="h-14.5 hidden lg:block"></div>
    @endif
    </body>
</x-app-layout>