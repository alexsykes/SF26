<x-admin>
    <div class="flex font-semibold  text-violet-700  justify-between">
        <div class="font-semibold">Clubs</div>
        <div class="font-semibold pr-4"><a href="/club/add"><i class=" fa-solid fa-plus"></i></a></div>
    </div>
    <div class="mb-4 w-full">
        @foreach($clubs as $club)
            <div class="w-full justify-between flex columns-4">
                <div class="col-span-1">{{$club->Name}}</div>
                <div class="col-span-1">{{$club->Area}}</div>
                <div class="col-span-1"><a href="mailto:{{$club->Email}}">{{$club->Contact}}</a></div>
                <div class="col-span-1">{{$club->Phone}}</div>
                <div class="col-span-1 mr-4"><a href="/club/edit/{{$club->id}}">Edit</a></div>
            </div>
        @endforeach
    </div>
</x-admin>