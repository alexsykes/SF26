<x-clubmail>
    <body class="">
    <p>Dear {{$name}}, <br>I am pleased to confirm that your Data Request has now been approved with the following
        comment:</p>
    @php
        echo $request->comments;
    @endphp
    <p>The data which you requested is attached to this email. I hope that you will be able to make use of this data.
    </p>
    <p>Thanks for your request.<br>Alex - SlopeFinder Admin</p>
    </body>
</x-clubmail>