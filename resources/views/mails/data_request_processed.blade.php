<x-clubmail>
    <body class="">
    @if($request->approved == "Approved")
        <p>Dear {{$name}}, <br>I am pleased to confirm that your Data Request has now been approved with the following
            comment - {{$request->comments}}. The data which you requested is attached to this email. I hope that you will be able to make use of this data.
        </p>
    @else
        <p>Dear {{$name}}, <br>
            Thank you for the data request received recently. Unfortunately, on this occasion, the request has been refused for the following reason(s):</p>
        <p>{{$request->comments}}</p>
        <p>This was not viewed as a malicious request and further requests would be welcomed and considered</p>
    @endif
    <p>Thanks for your request.<br>Alex - SlopeFinder Admin</p>
    </body>
</x-clubmail>