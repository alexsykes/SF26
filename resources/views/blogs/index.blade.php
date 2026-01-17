<x-admin><title>Blogs</title>
    <table class="w-full table-fixed">
        <thead>
        <tr>
            <th class="w-1/6">Title</th>
            <th>Description</th>
            <th class="max-sm:hidden">Category</th>
            <th class="max-sm:hidden">Created</th>
            <th class="max-sm:hidden">Updated</th>
            <th class="max-w-min text-center">Edit</th>
            <th class="max-w-min text-center">Publish</th>
        </tr>
        </thead>
        <tbody>
        @foreach($posts as $post)
            <tr>
                <td>{{$post->title}}</td>
                <td>{{$post->subtitle}}</td>
                <td class="max-sm:hidden">{{ucfirst($post->category)}}</td>
                <td class="max-sm:hidden">{{$post->created_at}}</td>
                <td class="max-sm:hidden">{{$post->updated_at}}</td>
                <td class="max-w-min text-center"><a href="/blog/edit/{{$post->id}}"><i
                                class="fa-solid fa-edit"></i></a></td>
                <td class="max-w-min text-center">
                    <div id="togglePublished" onclick="togglePublished()"
                         onmouseover="this.style.cursor='pointer'"
                         class="fa-solid fa-eye"></div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <script>
        function togglePublished() {
            console.log("i Clicked");
        }
    </script>

</x-admin>