<x-clubmail>
    <body class="">
    <p>Dear {{$name}}, <br>This email is to acknowledge submission of a new site for inclusion in the SlopeFinder
        database. The submission was shown as originating from your account.
    </p>
    <p>The site suggestion referred to: '{{$site->site_name}}' located near {{$site->near}}.
    </p>
    <p>Thank you for contributing and helping build our library of soaring sites. We will contact you again once the
        site is published.</p>
    <p>Thanks, again, <br>Alex - SlopeFinder Admin</p>
    </body>
</x-clubmail>