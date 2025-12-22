<x-admin>
    <div class="font-semibold">
        Mail list
    </div>
    @foreach($clubmails as $mail)
        <div class=" w-full">
            <div class=" border mt-2 mb-2 p-2 rounded-lg shadow-sm border-spacing-2 border-gray-100 text-sm ">
                <details class="text-xs">
                    <summary class="text-sm">{{$mail->subject}}</summary>
                    <a href="/mail/edit/{{$mail->id}}">@php echo $mail->content; @endphp</a>
                </details>
            </div>
        </div>
    @endforeach
</x-admin>