<x-admin>
    <form action="/club/store" method="post">
        @csrf
        <div id="container" class="mt-2 grid grid-cols-1 gap-x-4 gap-y-2 sm:grid-cols-4">

            <div class="sm:col-span-4">
                <label for="Name" class="block  font-semibold ">Club Name</label>
                <div class="mt-2">
                    <div>
                        <input type="text"
                               class="w-full md:w-1/2"
                               name="Name"
                               value="{{old('Name')}}"
                               id="Name"
                               placeholder="Required">
                    </div>
                </div>
                @error('Name')
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
                               value="{{old('Area')}}"
                               id="Area"
                               placeholder="Required">
                    </div>
                </div>
                @error('Area')
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
                               value="{{old('Contact')}}"
                               id="Contact"
                               placeholder="Required">
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
                               value="{{old('Phone')}}"
                               id="Phone"
                               placeholder="Optional">
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
                        <input type="email"
                               class="w-full md:w-1/2"
                               name="Email"
                               value="{{old('Email')}}"
                               id="Email"
                               placeholder="Required">
                    </div>
                </div>
                @error('Email')
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
                               value="{{old('Website')}}"
                               id="Website"
                               placeholder="Optional">
                    </div>
                </div>
                @error('Website')
                <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>


            <div class="sm:col-span-4">
                <label for="Description" class="block  font-semibold ">Description</label>
                <div class="mt-2">
                    <div>
                        <textarea type="text"
                                  class="w-full md:w-1/2"
                                  id="Description"
                                  name="Description"
                                  placeholder="Please give as much information as possible">{{old("Description")}}</textarea>
                    </div>
                </div>
                @error('Description')
                <p class=" text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
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
                                  placeholder="Optional">{{old("Notes")}}</textarea>
                    </div>
                </div>
                @error('Notes')
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
                Submit
            </button>
        </div>
    </form>

</x-admin>
