<x-app-layout>
    <script>
        var sites = <?php echo json_encode($sites); ?>;

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


        for (i = 0; i < 3; i++) {
            site = sites[i];
            lat = site['lat'];
            lng = site['lng'];
            initMap(i, site);
        }
    </script>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">
            {{ __('Sites') }}
        </h2>
    </x-slot>

    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl p-4 md:p-12">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            @php
                for ($i = 0; $i < 3; $i++) {
                $site = $sites[$i];
            @endphp
            <div class="bg-white map shadow-xl relative aspect-4/3 overflow-hidden rounded-xl border border-neutral-200
                    dark:border-neutral-700">
                <div id="map{{$i}}" class="bg-slate-500 w-full aspect-square"></div>
                <div class="font-semibold  bg-white p-2 pb-0 ">{{$site['site_name']}}</div>
                <div class="p-2  bg-white ">{{$site['site_description']}}</div>
            </div>
            @php
                }
            @endphp
        </div>
    </div>
</x-app-layout>
