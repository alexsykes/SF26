<x-app-layout>
    @php $isFavourite = true;
    @endphp
    <x-slot name="header">

        <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">
            User feedback - {{$site->site_name}}
        </h2>
    </x-slot>


    <form method="POST" action="/site_user_update">
        @csrf
        <input type="hidden" id="site_id" name="site_id" value="{{$site->id}}">
        <div class="visible p-2  bg-white shadow-xl flex mt-4 ml-4 mr-4 h-full flex-1 flex-col gap-1 rounded-xl border border-neutral-200">
            <div class="flex  h-full w-full flex-1 flex-col gap-4 rounded-xl p-2 md:p-4">
                <div>Your comments will be recorded as having been submitted by {{$user->email}}</div>


                <x-form-field>
                    <x-form-label for="comment">Comment - please enter as much detail as possible</x-form-label>
                    <div class="mt-2 ">
                        <textarea rows="5" class="w-full resize border border-blue-gray-200" name="comment" type="text"
                                  id="comment"></textarea>
                    </div>
                    @error('comment')
                    <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </x-form-field>

                <div class="block">
                    <label for="copy_me" class="inline-flex items-center">
                        <input id="copy_me" type="checkbox"
                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                               name="copy_me">
                        <span class="ms-2 text-sm text-black">{{ __('Email a copy to myself') }}</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="p-4 flex space-x-4">
            <button class="border bg-white p-2 pr-4 pl-4 shadow-md hover:bg-gray-200 "
                    onclick="history.back()">Go
                Back</button>
            <button type="submit" class="border bg-white  p-2 pr-4 pl-4 shadow-md hover:bg-gray-200 ">Submit</button>
        </div>

        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif

    </form>
</x-app-layout>