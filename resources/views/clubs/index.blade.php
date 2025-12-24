<x-admin>
    <div class="font-semibold">Clubs</div>
    <div class="mb-4 w-full">
        @foreach($clubs as $club)
            <div class="w-full justify-between flex columns-4">
                <div class="col-span-1">{{$club->Name}}</div>
                <div class="col-span-1">{{$club->Area}}</div>
                <div class="col-span-1"><a href="mailto:{{$club->Email}}">{{$club->Contact}}</a></div>
                <div class="col-span-1">{{$club->Phone}}</div>
            </div>
        @endforeach
    </div>
</x-admin>