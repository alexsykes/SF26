<x-admin>
    <div class="sm:columns-5 text-violet-700  font-semibold">
        <div>Details</div>
        <div>Purpose</div>
        <div>Format</div>
        <div>Name</div>
        <div>Status</div>
    </div>
    @foreach($dataRequest as $request)
        @php
            $url = "/request/process/$request->id";
//echo $request->approved;
        @endphp
        <div class="sm:columns-5">
            <div><a href="{{$url}}">{{$request->description}}</a></div>
            <div><a href="{{$url}}">{{$request->purpose}}</a></div>
            <div><a href="{{$url}}">{{$request->data_format}}</a></div>
            <div><a href="{{$url}}">{{$request->name}}</a></div>
            <div><a href="{{$url}}">{{$request->approved}}</a></div>
        </div>
    @endforeach
</x-admin>