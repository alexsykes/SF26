<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            Data Request
        </h2>
    </x-slot>
    @php
        $formatArray = array("JSON", "CSV", "TAB","SQL", "PDF", "Other");
    @endphp
    <div class="visible p-4 text-sm  bg-white shadow-xl flex mt-4 ml-4 mr-4 h-full flex-1 flex-col gap-1 rounded-xl border border-neutral-200 ">
        <div class="text-sm space-y-2">
            <div>In recognition of the sources of much of the data and the general ethos of the soaring
                community, we are
                happy to allow some data to be shared under a Creative Commons CC-BY-NC licence. This licence permits
                the Non-Commercial use of the data provided attribution of the source is included in its use. The full
                details of the licence can be found <a class="font-semibold underline text-violet-700"
                                                       href="https://creativecommons.org/licenses/by-nc/4.0/">here.</a>
            </div>
            <div>It is hoped that this availability will reduce the risk of this data being lost forever.</div>

            <div>Registered users of this website are invited to request copies of both the website source code and the
                data related to the slope-soaring sites represented here.
            </div>
            <div class="font-semibold text-violet-700">Please note - NO data relating to registered users of this
                website will be shared.
            </div>
        </div>
        <form action="/dataRequest/submit" method="post">
            @csrf
            <div class="mt-2 grid grid-cols-1 gap-x-4 gap-y-2 sm:grid-cols-4">
                <div class="sm:col-span-4">
                    <label for="description" class="block  font-semibold ">Data Requested</label>
                    <div class="mt-2">
                        <input type="text"
                               class="w-full"
                               name="description"
                               id="description"
                               required
                               placeholder="What data you require">
                    </div>
                    @error('description')
                    <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-4">
                    <label for="purpose" class="block  font-semibold ">Purpose</label>
                    <div class="mt-2">
                        <input type="text"
                               class="w-full"
                               name="purpose"
                               id="purpose"
                               required
                               placeholder="What use you will put the data to…">
                    </div>
                    @error('purpose')
                    <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-4">
                    <label for="format" class="block font-semibold">File format</label>
                    <div class="mt-2">
                        @foreach($formatArray as $option)
                            <input name="format" type="radio" id="format" value="{{$option}}"
                                   {{ (old('format') == $option) ? ' checked' : '' }}
                                   required>
                            <label class="pl-1 pr-4" for="format">{{$option}}</label>
                        @endforeach
                    </div>
                    @error('format')
                    <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-4">
                    <label for="purpose" class="pt-2 block  font-semibold ">I have read the terms and conditions of the
                        Creative
                        Commons CC-BY-NC licence and agree to abide by them.</label>
                    <input type="checkbox" required id="accept" name="accept" value="1" class="mt-1 block"/>
                </div>
            </div>
            <div class=" pl-0 pt-6 flex space-x-4">
                <button class="border bg-white p-2 pr-4 shadow-md hover:bg-gray-200 "
                        onclick="history.back()">Go
                    Back
                </button>
                <button type="submit"
                        class="border bg-black text-white  p-2 pr-4 pl-4 shadow-md hover:bg-gray-700 ">
                    Submit
                </button>
            </div>
        </form>
    </div>
</x-app-layout>