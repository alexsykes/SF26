<x-admin><title>Blogs</title>
    <table class="w-full table-fixed">
        <thead>
        <tr>
            <th class="w-1/6">Title</th>
            <th>Description</th>
            <th class="max-sm:hidden">Category</th>
            <th class="max-sm:hidden">Created</th>
            <th class="max-sm:hidden">Updated</th>
            <th class="w-min text-center">Edit</th>
            <th class="w-min text-center">Published</th>
        </tr>
        </thead>
        <tbody>
        @foreach($posts as $post)
            @php
                $published = $post->published;

                if($published) {
                    $pbImg = "fa-regular fa-eye";
                } else {
                    $pbImg ="fa-regular fa-eye-slash";
                }
            @endphp
            <tr>
                <td>{{$post->title}}</td>
                <td>{{$post->subtitle}}</td>
                <td class="max-sm:hidden">{{ucfirst($post->category)}}</td>
                <td class="max-sm:hidden">{{$post->created_at}}</td>
                <td class="max-sm:hidden">{{$post->updated_at}}</td>
                <td class="w-min text-center"><a href="/blog/edit/{{$post->id}}"><i
                                class="fa-regular fa-edit"></i></a></td>
                <td class="w-min text-center">
                    <div id="togglePublished" onclick="togglePublished()"
                         onmouseover="this.style.cursor='pointer'"
                         class="{{$pbImg}}"></div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $posts->links() }}

    <div class="mt-4">
        <form action="/blog/form" method="post">
            @csrf
            <button class="border text-white rounded-lg bg-black p-2 pr-4 pl-4 shadow-md hover:bg-gray-600 "
                    type="submit"
                    name="action"
                    value="new">New
            </button>
        </form>
    </div>
    <script>
        function togglePublished() {
            console.log("i Clicked");
        }
    </script>


</x-admin>