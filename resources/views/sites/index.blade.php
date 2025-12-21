<x-admin>
    @foreach($sites as $site)
        <div>{{$site->site_name}}</div>
    @endforeach
</x-admin>