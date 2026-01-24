<x-admin>
    <script>
        tinymce.init({
            selector: 'textarea.withEditor',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | image media table | align lineheight | link numlist bullist indent outdent | emoticons charmap | removeformat',
            link_assume_external_targets: true,
            relative_urls: false,
            remove_script_host: false,
            convert_urls: true,
            mobile: {
                menubar: true
            },
        });
    </script>
    @php
        $categoryArray = array("General","Sites", "Clubs", "Development");
    @endphp


    <div id="container">
        @error('')
        {{ $message }}
        @enderror
        <form method="POST" action="/blog/store">
            <input type="hidden" name="published" id="published" value="true">
            <div class="w-full  grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-6">
                @csrf
                <div id="titleContainer" class="col-span-3">
                    <div>
                        <label class="font-semibold text-slate-400" for="titleInput">Title</label></div>
                    <div class="mt-2">
                        <input class=" " name="title" type="text" id="title"
                               value="{{old('title')}}"
                               required/>
                    </div>
                    @error('title')
                    <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div id="subTitleContainer" class="col-span-3">
                    <div>
                        <label class="font-semibold text-slate-400" for="subTitleInput">Subtitle</label>
                        <div class="mt-2">
                            <input class="" name="subtitle" type="text" id="subtitle"
                                   value="{{old('subtitle')}}"
                                   required/>
                        </div>
                    </div>
                    @error('subtitle')
                    <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div id="categoryDiv" class="col-span-3">
                    <label class="font-semibold text-slate-400" for="category">Category</label>
                    <div class="mt-2">
                        @foreach($categoryArray as $option)
                            <input name="category" type="radio" id="category" value="{{$option}}"
                                   {{ (old('category') == $option) ? ' checked' : '' }}
                                   required>
                            <label class="pl-1 pr-4" for="category">{{$option}}</label>
                        @endforeach
                    </div>
                    @error('category')
                    <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div id="publishDiv" class="col-span-3">
                    <label class="font-semibold text-slate-400" for="category">Published</label>
                    <div class="mt-2">
                        <input name="published" id="published" type="checkbox" checked>
                    </div>
                </div>


                <div id="mailBodyTextDiv" class="w-full col-span-full mt-2">

                    <label class="font-semibold text-slate-400" for="content">Email body</label>
                    <div class="mt-2 ">
                        <textarea class=" w-full" name="content" type="text" id="content">
                                {{old('content')}}
                        </textarea>
                    </div>
                </div>
                @error('content')
                <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                @enderror

            </div>
            <div id="buttons" class="mt-4 w-full space-x-4">
                <a class="border rounded-lg bg-white p-2 pr-4 pl-4 shadow-md hover:bg-gray-200 "
                   onclick="history.back()">Cancel
                </a>
                <button class="border text-white rounded-lg bg-black p-2 pr-4 pl-4 shadow-md hover:bg-gray-600 "
                        type="submit"
                        name="action"
                        value="save">Save
                </button>
            </div>
        </form>
    </div>
</x-admin>