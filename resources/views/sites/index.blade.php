<x-admin>
    <div class="font-semibold">Sites for approval</div>
    <div class="mb-4">
        @foreach($newSites as $site)
            <div class="flex text-sm">
                <div class="font-semibold sm:w-1/5"><a href="/site/edit/{{$site->id}}">{{$site->site_name}}</a></div>
                <div class="col-span-1"><a href="/site/publish/{{$site->id}}">Publish</a></div>
            </div>
        @endforeach
    </div>


    <div class="mb-4">
        <div class="font-semibold">Feedback</div>
        {{--        @dd($suggestions)--}}
        @foreach($suggestions as $suggestion)
            <div class="flex text-sm">
                <div class="font-semibold sm:w-1/5"><a
                            href="/site/edit/{{$suggestion->siteID}}">{{$suggestion->site_name}}</a></div>
                <div class=" sm:w-4/5">{{$suggestion->suggestion}}</div>
            </div>
        @endforeach
    </div>

    <div class="mb-4">
        <div class="font-semibold">Sites</div>
        <div class="text-sm columns-2  sm:columns-5">
            @foreach($sites as $site)
                <div class="col-span-1"><a href="/site/edit/{{$site->id}}">{{$site->site_name}}</a></div>

            @endforeach
        </div>
    </div>
</x-admin>