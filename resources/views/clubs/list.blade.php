<x-app-layout>
    <div id="container" class="space-y-8 p-4">
        <div class="bg-white p-4 pt-2 border border rounded-2xl shadow-xl">
            <div class="font-semibold text-violet-700">Clubs</div>
            <div class="mb-4">
                @foreach($clubs as $club)
                    {{--                    @dump($site)--}}
                    @php
                        $updated_ = date_create($club->created_at);
                $updated_at = date_format($updated_, 'F, Y');
                    @endphp
                    <div class="sm:flex text-sm pt-2">
                        <div class="text-violet-700 font-semibold sm:w-1/5">{{$club->Name}}<br>
                            Contact: {{$club->Contact}}</div>
                        <div class="sm:pl-2 col-span-1 sm:w-4/5">@php echo $club->Description; @endphp</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>