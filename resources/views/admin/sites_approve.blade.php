<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">Sites for Approval</h2>
    </x-slot>
    <div class="visible  bg-white shadow-xl flex mt-4 ml-4 mr-4 h-full flex-1 flex-col gap-1 rounded-xl border border-neutral-200">
        <table class="table-auto">
            <thead>
            <tr>
                <th class="hidden sm:block">Date</th>
                <th>Site ID</th>
                <th>Name</th>
                <th>Location</th>
                <th>Submitter</th>
            </tr>
            </thead>
            <tbody class="p-0">
            @foreach($sites as $site)
                @php
                    $user = DB::table('users')
                ->where('id', $site->created_by)
                ->first('users.name');

//                    dd($user);
                @endphp
                <tr class=" align-top odd:bg-gray-100">
                    <td class="hidden sm:block sm:pl-4 ">{{$site->created_at}}</td>
                    <td class=" pl-4 ">{{$site->id}}</td>
                    <td class="pl-4">{{$site->site_name}}</td>
                    <td><a href="/site/edit/{{$site->id}}">{{$site->near}}</a></td>
                    <td>{{$user->name}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>