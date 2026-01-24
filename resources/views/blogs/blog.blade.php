<x-app-layout>

    <div id="container" class="space-y-8 p-4">
        @foreach($blogPosts as $blogPost)
            @dump($blogPost->comments())
            <x-blog-item :blogPost="$blogPost"/>
        @endforeach
    </div>
</x-app-layout>