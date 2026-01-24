<div>
    <div class="bg-white p-4 pt-2 border border rounded-2xl shadow-xl">
        <details>
            <summary id="title" name="title" class="font-semibold text-lg text-violet-600">{{$blogPost->title}}
                <div id="subtitle" name="subtitle" class="font-semibold text-slate-600">{{$blogPost->subtitle}}</div>
            </summary>
            <div id="content" name="content"
                 class="font-normal text-black">@php echo $blogPost->content @endphp</div>
            <div id="timestamps" name="timestamps" class="italic text-xs text-slate-600 pt-2">{{$created_at  }}</div>
            <form method="POST" action="/comment/submit">
                @csrf
                <input type="hidden" id="post_id" name="post_id" VALUE="{{$blogPost->id}}">
                <input type="text" id="comment" name="comment"
                       required
                       class="w-full mt-2 mb-4"
                       placeholder="Comment - maximum 255 characters">
                <x-primary-button type="submit">Submit</x-primary-button>
            </form>
        </details>
    </div>
</div>