<x-admin>
    @php
        $approvalOptions = array("Pending", "Approved", "Refused");
        $tableArray = array("Sites","Wind Directions for Sites","Clubs");
    @endphp
    <div>Data requested - {{$dataRequest->description}}</div>
    <div>Purpose - {{$dataRequest->purpose}}</div>
    <div>Format - {{$dataRequest->format}}</div>
    <div>Requested by - {{$dataRequest->approved}}</div>

    <div class="mt-4" id="requestFormDiv">
        <form action="/request/respond" method="post">
            @csrf
            <input type="hidden" value="{{$dataRequest->id}}" name="id" id="id">

            <div class="col-span-full">
                <label for="comments" class="block  font-semibold ">Feedback</label>
                <div class="mt-2">
                  <textarea
                          name="comments"
                          id="comments"
                          rows="3"
                          required
                          class="block w-full rounded-md bg-white px-3 py-1.5 text-base  outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:"
                          placeholder="">{{$dataRequest->comments}}</textarea>
                </div>

                @error('comments')
                <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="sm:col-span-4 mt-4">
                <label for="approved" class="block font-semibold">Request Approval</label>

                <div class="">
                    @foreach($approvalOptions as $option)
                        <input name="approved" type="radio" id="approved" value="{{$option}}"
                               {{ ($dataRequest->approved == $option) ? ' checked' : '' }}
                               required>
                        <label class="pl-1 pr-4" for="approved">{{$option}}</label>
                    @endforeach
                </div>
                @error('approved')
                <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <label for="completed" class="block font-semibold mt-4">Mark as Completed</label>
            <input type="checkbox" id="completed" name="completed" value="1" class="mt-1 block"/>


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


    <div class="mt-4" id="exportFormDiv">
        <form action="/request/export" method="post">
            @csrf
            <input type="hidden" value="{{$dataRequest->id}}" name="id" id="id">
            <input type="hidden" value="{{$dataRequest->format}}" name="format" id="format">


            <label class="pr-0 block font-semibold" for="tables">Select tables for export
                as {{$dataRequest->format}}</label>
            <div class="mt-2 pl-2 pr-0">
                @foreach($tableArray as $table)
                    <div>
                        <input name="tables[]" type="checkbox"
                               value="{{$table}}"
                                @php
                                    if(isset($tableSelected)) {
                                    $selected = in_array($table, $tableSelected) ? ' checked ' : '';
                                    echo $selected;
                                    }
                                @endphp
                        />
                        <label class="pl-4 pr-0" for="tables">{{$table}}
                        </label>
                    </div>
                @endforeach
            </div>
            @error('tables')
            <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
            @enderror


            <div class=" pl-0 pt-6 flex space-x-4">
                <button type="submit"
                        class="border bg-black text-white  p-2 pr-4 pl-4 shadow-md hover:bg-gray-700 ">
                    Process
                </button>
            </div>

        </form>
    </div>
</x-admin>