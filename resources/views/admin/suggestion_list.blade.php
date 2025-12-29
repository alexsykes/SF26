<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            User Feedback
        </h2>
    </x-slot>

    <div class="visible  bg-white shadow-xl flex mt-4 ml-4 mr-4 h-full flex-1 flex-col gap-1 rounded-xl border border-neutral-200">
        <table class="table-auto">
            <thead>
            <tr>
                <th class="hidden sm:block">Date</th>
                <th>Site</th>
                <th>Comment</th>
                <th>User</th>
            </tr>
            </thead>
            <tbody class="p-0">
            @foreach($suggestions as $suggestion)
                <tr class=" align-top odd:bg-gray-100">
                    <td class="hidden sm:block sm:pl-4 ">{{$suggestion->created_at}}</td>
                    <td class="pl-4">{{$suggestion->site_name}}</td>
                    <td><a href="/site/edit/{{$suggestion->siteID}}">{{$suggestion->suggestion}}</a></td>
                    <td class="pr-4"><a href="mailto:{{$suggestion->email}}">{{$suggestion->name}}</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>