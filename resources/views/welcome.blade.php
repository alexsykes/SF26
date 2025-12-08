<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet"/>

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        function success(position) {
            document.cookie = "lat=" + position.coords.latitude;
            document.cookie = "lng=" + position.coords.longitude;
            console.log("Cookies saved");
        }

        document.addEventListener("DOMContentLoaded", function () {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(success);
                console.log("Request location");
            } else {
                console.log("Geolocation is not supported by this browser.");
            }
            navigator.permissions.query({name: 'geolocation'})
                .then(console.log)
        });

    </script>

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
                center: {lat: {{$randomSite->lat}}, lng: {{$randomSite->lng}}},
                zoom: 14,
                streetViewControl: false,
                mapTypeControl: false,
                mapTypeId: google.maps.MapTypeId.TERRAIN,
                mapId: "c2290875eac93973",
            });
            const marker = new AdvancedMarkerElement({
                map,
                position: {lat: {{$randomSite->lat}}, lng: {{$randomSite->lng}}},
            });
        }

        initMap();
    </script>
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-2 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
<header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
    @if (Route::has('login'))
        <nav class="flex items-center justify-end gap-4">
            @auth
                <a
                        href="{{ url('/dashboard') }}"
                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                >
                    Dashboard
                </a>
            @else
                <a
                        href="{{ route('login') }}"
                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                >
                    Log in
                </a>

                @if (Route::has('register'))
                    <a
                            href="{{ route('register') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                        Register
                    </a>
                @endif
            @endauth
        </nav>
    @endif
</header>
<div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
    <main class="flex ml-4 mr-4 w-full flex-col-reverse lg:max-w-4xl lg:flex-row  shadow-2xl">
        <div class="text-[13px] leading-[20px] flex-1 p-6 pb-12 lg:p-12 bg-white dark:bg-[#161615] dark:text-[#EDEDEC] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-bl-lg rounded-br-lg lg:rounded-tl-lg lg:rounded-br-none">
            <h1 class="mb-1 font-medium">What's it all about?</h1>
            <p class="mb-2 text-[#706f6c] dark:text-[#A1A09A]">Developed from Simon Steven's now-retired Weather
                Permitting site, SlopeFinder aims to provide a useful resource for the slope-soaring community.</p>
            <h1 class="mb-1 font-medium">History</h1>
            <p class="mb-2 text-[#706f6c] dark:text-[#A1A09A]">
                Quite a few years ago, Simon Stephens set up his WeatherPermitting website - don't go looking for it,
                it's not there now - although it's in the online Wayback Machine. The site gathered together details of
                several hundred slope soaring sites throughout the British Isles. Although it no longer exists, Simon
                has generously shared the data which is available here for the benefit of the soaring community.
                The current site uses and extends this data to offer a continuation of that approach.</p>
            <h1 class="mb-1 font-medium">Why do I need to register?</h1>
            <p class="mb-2 text-[#706f6c] dark:text-[#A1A09A]">Several reasons. Firstly, registration will give you full
                access to the site's database of slopes. Secondly,to accept the Conditions of Use of the site and
                confirm that you will respect landowners, clubs and other users. And finally, you will be able to make
                your own contribution by adding new or updating existing site information.</p>
            <h1 class="mb-1 font-medium">Example site - {{$randomSite->site_name}}</h1>
            <p class="mb-2 text-[#706f6c] dark:text-[#A1A09A]">{{$randomSite->site_description}}</p>
        </div>
        <div class="bg-[#fff2f2] dark:bg-[#1D0002] relative lg:-ml-px -mb-px lg:mb-0 rounded-t-lg lg:rounded-t-none lg:rounded-r-lg aspect-[335/376] lg:aspect-auto w-full lg:w-[438px] shrink-0 overflow-hidden">
            {{-- Laravel Logo --}}
            {{----}}

            <div class="map100" id="map"></div>
            {{--                    <div class="absolute inset-0 rounded-t-lg lg:rounded-t-none lg:rounded-r-lg shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]"></div>--}}
        </div>
    </main>
</div>

@if (Route::has('login'))
    <div class="h-14.5 hidden lg:block"></div>
@endif
</body>
</html>
