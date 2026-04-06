<x-admin>
    @php
        $approvalOptions = array("Pending", "Approved", "Refused");
        $tableValueArray = array("Sites","Wind Directions for Sites","Clubs");
        $tableNameArray = array("sites","site_wind_directions","clubs");
        $selectedTables = explode(',',$dataRequest->tables);

    @endphp
    @if ($errors->any())
        <div class="text-red-500 bg-red-100 border-red-500 border shadow-lg rounded-lg p-2 pl-4 alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div>Data requested - {{$dataRequest->description}}</div>
    <div>Purpose - {{$dataRequest->purpose}}</div>
    <div>Format - {{$dataRequest->data_format}}</div>
    <div>Requested by - {{$dataRequest->name}}</div>

    <div class="mt-4" id="requestFormDiv">
        <form action="/request/action" method="post">
            @csrf
            <input type="hidden" value="{{$dataRequest->id}}" name="id" id="id">
            <div class="col-span-full">
                <label for="comments" class="block  font-semibold ">Feedback</label>
                <div class="mt-2">
                  <textarea
                          name="comments"
                          id="comments"
                          rows="3"

                          class="block w-full rounded-md bg-white px-3 py-1.5 text-base  outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:">
                      {{$dataRequest->comments}}
                  </textarea>
                </div>

                @error('comments')
                <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="sm:col-span-4 mt-4">
                <label for="approved" class="block font-semibold">Request Approval</label>

                <div class="">
                    @foreach($approvalOptions as $option)
                        <input onchange="toggle(exportFormDiv, value)" name="approved" type="radio" id="approved"
                               value="{{$option}}"
                               {{ ($dataRequest->approved == $option) ? ' checked' : '' }}
                               required>
                        <label class="pl-1 pr-4" for="approved">{{$option}}</label>
                    @endforeach
                </div>
                @error('approved')
                <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>

            @if($dataRequest->approved == 'Approved')
                <div class="mt-4" id="exportFormDiv">
                    @else
                        <div class="hidden mt-4" id="exportFormDiv">
                            @endif
                            <label class="pr-0 block font-semibold" for="tables">Select tables for export
                                as {{$dataRequest->data_format}}</label>
                            <div class="mt-2 pl-2 pr-0">
                                @for($i=0; $i<sizeof($tableValueArray); $i++)
                                    <div>
                                        <input name="tables[]" type="checkbox"
                                               value="{{$tableNameArray[$i]}}"
                                                @php
                                                    if(isset($selectedTables)) {
                                                    $selected = in_array($tableNameArray[$i], $selectedTables) ? ' checked ' : '';

                                                    echo $selected;
                                                    }
                                                @endphp
                                        />
                                        <label class="pl-4 pr-0" for="tables">{{$tableValueArray[$i]}}
                                        </label>
                                    </div>
                                @endfor
                            </div>
                            @error('tables')
                            <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div id="buttons" class=" pl-0 pt-6 flex space-x-4">
                            <button class="border bg-white p-2 pr-4 shadow-md hover:bg-gray-200 "
                                    onclick="history.back()">Go
                                Back
                            </button>
                            <button type="submit" value="update" name="submit"
                                    class="border bg-gray-200 text-black  p-2 pr-4 pl-4 shadow-md hover:bg-gray-400 ">
                                Update
                            </button>
                            <button type="submit" value="process" name="submit"
                                    class="border bg-black text-white  p-2 pr-4 pl-4 shadow-md hover:bg-gray-700 ">
                                Process
                            </button>

                        </div>
                </div>
        </form>
    </div>
</x-admin>