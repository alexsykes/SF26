<x-clubmail>
    <body class="">

    <p>Dear {{$name}}, <br>
        Thank you for the data request received recently. Unfortunately, on this occasion, the request has been refused
        for the following reason(s):</p>
    @php
        echo $comments;
    @endphp
    <p>This was not viewed as a malicious request and further requests would be welcomed and considered</p>
    <p>Thanks for your request.<br>Alex - SlopeFinder Admin</p>
    </body>
</x-clubmail>