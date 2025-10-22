{{--@dd($sites)--}}    @php
    $numSites = sizeof($sites);

    $sitesHTML = "";
    foreach($sites as $site) {
        $site_name = $site['site_name'];
        $site_distance = $site['distance_km'];
        $begin = $site['begin'];
        $end = $site['end'];
        $siteID = $site['id'];


           $sitesHTML .= "<a href=\"/site/detail/{$siteID}\"><div class=\" grid grid-cols-4 w-full\">
           <div class=\"col-span-3\"><b>$site_name</b> ($begin - $end) </div>";
           $sitesHTML .= "<div class=\"col-span-1 text-end\"> $site_distance km</div></div></a>";

}
//    dd($sitesHTML);
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">
            {{ __('Sites (A-Z)') }}
        </h2>

    </x-slot>

    <div class="visible bg-white shadow-xl flex mt-4 ml-4 mr-4 h-full flex-1 flex-col gap-1 rounded-xl border border-neutral-200 md:hidden">
        @foreach($sites as $site)
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