<x-automail>
{{--@dump($mail)--}}
    {{--    @dd($replyToName, $replyToAddress);--}}
    <form method="POST" action="/mail/update">
        @method('PATCH')
        @csrf
        <input type="hidden" name="id" id="id" value="{{$mail->id}}">
        <div>
            <label for="subject" class="block  font-semibold ">Subject (Required)</label>
            <div class="mt-2 ">
                <div>
                    <input type="text"
                           class="w-full md:w-1/2"
                           name="subject"
                           value="{{$mail->subject}}"
                           required
                           id="subject"
                           placeholder="Site updates">
                </div>
            </div>
            @error('subject')
            <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
            @enderror
        </div>
        <x-forms.tinymce-editor/>
        <div>
            <label for="replyToName" class="block  font-semibold ">Reply to</label>
            <div class="mt-2 ">
                <div>
                    <input type="text"
                           class="w-full md:w-1/2"
                           name="replyToName"
                           value="{{$mail->replyToName}}"
                           required
                           id="replyToName"
                           placeholder="Name">
                </div>
            </div>
            @error('replyToName')
            <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="replyToAddress" class="block  font-semibold ">Reply email</label>
            <div class="mt-2 ">
                <div>
                    <input type="text"
                           class="w-full md:w-1/2"
                           name="replyToAddress"
                           value="{{$mail->replyToAddress}}"
                           required
                           id="replyToAddress"
                           placeholder="Email address">
                </div>
            </div>
            @error('replyToAddress')
            <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="summary" class="block  font-semibold ">Summary</label>
            <div class="mt-2 ">
                <div>
                    <input type="text"
                           class="w-full md:w-1/2"Brief description of contents
                           name="summary"
                           value="{{$mail->summary}}"
                           required
                           id="summary"
                           placeholder="Brief description of contents">
                </div>
            </div>
            @error('summary')
            <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="content" class="block  font-semibold ">Content</label>
            <div class="mt-2 ">
                <div>
                                <textarea name="content"
                                          required
                                          id="content"
                                          rows="10"
                                          class="w-full"
                                          placeholder="Content">
                                    @php
                                        echo $mail->content;
                                    @endphp</textarea>
                </div>
            </div>
            @error('content')
            <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="p-4 pb-0 flex space-x-4">
            <button class="border bg-white p-2 pr-4 pl-4 shadow-md hover:bg-gray-200 "
                    onclick="history.back()">Cancel
            </button>

            <button type="submit"
                    class="border bg-black text-white  p-2 pr-4 pl-4 shadow-md hover:bg-gray-500 " name="action"
                    value="save">Save
            </button>

            <button type="submit"
                    class="border bg-black text-white  p-2 pr-4 pl-4 shadow-md hover:bg-gray-500 " name="action"
                    value="prepare">Prepare
            </button>
        </div>
    </form>
</x-automail>