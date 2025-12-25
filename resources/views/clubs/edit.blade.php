<x-admin>
    <form action="/club/update" method="post">
        @csrf
        @method('PATCH')
        <input type="hidden" name="id" id="id" value="{{$club->id}}">

        <div id="container" class="mt-2 grid grid-cols-1 gap-x-4 gap-y-2 sm:grid-cols-4">

            <div class="sm:col-span-4">
                <label for="Name" class="block  font-semibold ">Name</label>
                <div class="mt-2">
                    <div>
                        <input type="text"
                               class="w-full md:w-1/2"
                               name="Name"
                               value="{{ $club->Name }}"
                               id="Name"
                               placeholder="">
                    </div>
                </div>
                @error('Name')
                <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>


            <div class="sm:col-span-4">
                <label for="Contact" class="block  font-semibold ">Contact</label>
                <div class="mt-2">
                    <div>
                        <input type="text"
                               class="w-full md:w-1/2"
                               name="Contact"
                               value="{{ $club->Contact }}"
                               id="Contact"
                               placeholder="">
                    </div>
                </div>
                @error('Contact')
                <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>


            <div class="sm:col-span-4">
                <label for="Phone" class="block  font-semibold ">Phone</label>
                <div class="mt-2">
                    <div>
                        <input type="text"
                               class="w-full md:w-1/2"
                               name="Phone"
                               value="{{ $club->Phone }}"
                               id="Phone"
                               placeholder="">
                    </div>
                </div>
                @error('Phone')
                <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>


            <div class="sm:col-span-4">
                <label for="Email" class="block  font-semibold ">Email</label>
                <div class="mt-2">
                    <div>
                        <input type="text"
                               class="w-full md:w-1/2"
                               name="Email"
                               value="{{ $club->Email }}"
                               id="Email"
                               placeholder="">
                    </div>
                </div>
                @error('Email')
                <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>


            <div class="sm:col-span-4">
                <label for="Area" class="block  font-semibold ">Area</label>
                <div class="mt-2">
                    <div>
                        <input type="text"
                               class="w-full md:w-1/2"
                               name="Area"
                               value="{{ $club->Area }}"
                               id="Area"
                               placeholder="">
                    </div>
                </div>
                @error('Area')
                <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>


            <div class="sm:col-span-4">
                <label for="Description" class="block  font-semibold ">Description</label>
                <div class="mt-2">
                    <div>
                        <textarea type="text"
                                  class="w-full md:w-1/2"
                                  name="Description"
                                  id="Description"
                                  placeholder="">{{$club->Description}}</textarea>
                    </div>
                </div>
                @error('Description')
                <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:col-span-4">
                <label for="Notes" class="block  font-semibold ">Notes</label>
                <div class="mt-2">
                    <div>
                        <textarea type="text"
                                  class="w-full md:w-1/2"
                                  name="Notes"
                                  id="Notes"
                                  placeholder="">{{$club->Notes}}</textarea>
                    </div>
                </div>
                @error('Notes')
                <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>


            <div class="sm:col-span-4">
                <label for="Website" class="block  font-semibold ">Website</label>
                <div class="mt-2">
                    <div>
                        <input type="text"
                               class="w-full md:w-1/2"
                               name="Website"
                               value="{{ $club->Website }}"
                               id="Website"
                               placeholder="">
                    </div>
                </div>
                @error('Website')
                <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>

        </div>


        <div class="p-4  flex space-x-4">
            <button class="border bg-white p-2 pr-4 pl-4 shadow-md hover:bg-gray-200 "
                    onclick="history.back()">Go
                Back
            </button>
            <button type="submit" class="border bg-white  p-2 pr-4 pl-4 shadow-md hover:bg-gray-200 ">
                Update
            </button>
        </div>
    </form>

</x-admin>
