<div>
    {{--    @dump($blogPost)--}}
    @php
        //        $created_ = date_create($blogPost->created_at);
        //    $updated_ = date_create($blogPost->updated_at);
        //    $created_at = date_format($created_, "F dS, Y");
        //    $diff = date_diff($created_, $updated_);
        //
        //    $elapsed = $diff->days;
        //    if($elapsed > 1) {
        //    $updated_at = date_format($updated_, "F dS, Y");
        //        $created_at .= " (updated ".$updated_at.")";
        //    }
    @endphp

    <div class="bg-white p-4 pt-2 border border rounded-2xl shadow-xl">
        <div id="title" name="title" class="font-semibold text-lg text-violet-600">{{$blogPost->title}}</div>
        <div id="subtitle" name="subtitle" class="font-semibold text-slate-600">{{$blogPost->subtitle}}</div>
        <div id="content" name="content"
             class="font-normal text-black">@php echo $blogPost->content @endphp</div>
        <div id="timestamps" name="timestamps" class="italic text-xs text-slate-600 pt-2">{{$created_at  }}</div>
    </div>
</div>