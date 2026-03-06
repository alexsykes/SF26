<x-admin>
    <div class="flex font-semibold  text-violet-700  justify-between">
        <div class="font-semibold">Mails</div>
        <div class="font-semibold pr-4"><a href="/mail/compose"><i class=" fa-solid fa-plus"></i></a></div>
    </div>
    @foreach($clubmails as $mail)
        <div class=" w-full">
            <div class=" border mt-2 mb-2 p-2 rounded-lg shadow-sm border-spacing-2 border-gray-100 text-sm ">
                <details class="text-xs">
                    <summary class="text-sm flex justify-between">
                        <div>{{$mail->subject}}</div>
                        <div>{{$mail->summary}}</div>
                    </summary>
                    <a href="/mail/edit/{{$mail->id}}">@php echo $mail->content; @endphp</a>
                </details>
            </div>
        </div>
    @endforeach
</x-admin>