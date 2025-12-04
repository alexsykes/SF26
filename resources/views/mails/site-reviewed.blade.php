<x-mail>
    <body class="">
    <p>Dear {{$sender}}, <br>Your suggestion relating to {{$site}} has been reviewed.
    </p>
    <p>The text of your suggestions was: '{{$suggestion}}'.
    </p>
    <p>Thank you for contributing and helping to keep our data up-to-date. You can visit the updated site <a href="https://www.slopefinder.uk/site/detail/{{$siteID}}">here</a></p>
    </body>
</x-mail>