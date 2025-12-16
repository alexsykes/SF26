<x-automail>
    <body class="">
    <p>Dear {{$name}}, <br>I am pleased to let you know that your submitted site, {{$site->site_name}}, has now been
        published.
    </p>
    <p>You can visit the site <a href="{{config('app.url')}}/site/detail/{{$site->id}}">here</a></p>
    <p>Thanks, again, for your contribution.<br>Alex - SlopeFinder Admin</p>
    </body>
</x-automail>