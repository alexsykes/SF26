<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full ">
<head>
    <x-head.tinymce-config/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://kit.fontawesome.com/086d4db9c7.js" crossorigin="anonymous"></script>
    <script>
        function directionChanged() {
            let directionForm = document.getElementById('directionForm');
            let windDirection = document.getElementById('windDirection');
            let direction = windDirection.value;
            document.cookie = "dir=" + direction;
            console.log("Direction changed: " + direction);
            directionForm.submit();

            // this.form.submit();
        }

        function addYourLocationButton(map) {
            var controlDiv = document.createElement('div');

            var firstChild = document.createElement('button');
            firstChild.style.backgroundColor = '#fff';
            firstChild.style.border = 'none';
            firstChild.style.outline = 'none';
            firstChild.style.width = '40px';
            firstChild.style.height = '40px';
            firstChild.style.borderRadius = '2px';
            firstChild.style.boxShadow = '0 1px 4px rgba(0,0,0,0.3)';
            firstChild.style.cursor = 'pointer';
            firstChild.style.marginRight = '10px';
            firstChild.style.padding = '0px';
            firstChild.title = 'Your Location';
            controlDiv.appendChild(firstChild);

            var secondChild = document.createElement('div');
            secondChild.style.margin = '10px';
            secondChild.style.width = '18px';
            secondChild.style.height = '18px';
            secondChild.style.backgroundImage = 'url(https://maps.gstatic.com/tactile/mylocation/mylocation-sprite-1x.png)';
            secondChild.style.backgroundSize = '180px 18px';
            secondChild.style.backgroundPosition = '0px 0px';
            secondChild.style.backgroundRepeat = 'no-repeat';
            secondChild.id = 'you_location_img';
            firstChild.appendChild(secondChild);

            // google.maps.event.addListener(map, 'dragend', function () {
            //     $('#you_location_img').css('background-position', '0px 0px');
            // });

            firstChild.addEventListener('click', function () {
                var imgX = '0';
                var animationInterval = setInterval(function () {
                    if (imgX == '-18') imgX = '0';
                    else imgX = '-18';
                    // $('#you_location_img').css('background-position', imgX + 'px 0px');
                }, 500);
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

                        map.setCenter(latlng);
                        clearInterval(animationInterval);
                    });
                } else {
                    clearInterval(animationInterval);
                }
            });
            controlDiv.index = 1;
            map.controls[google.maps.ControlPosition.RIGHT_TOP].push(controlDiv);
        }

        function getCookieByName(name) {
            const cookies = document.cookie.split('; ');
            for (let cookie of cookies) {
                const [cookieName, cookieValue] = cookie.split('=');
                if (cookieName === name) {
                    return cookieValue;
                }
            }
            return null; // Return null if the cookie is not found
        }

        function toggle(divID, value) {
            // console.log(value);
            var element = document.getElementById(divID.id);
            if (value === "Approved") {
                element.style.display = "block"; // Show the element
            } else {
                element.style.display = "none"; // Hide the element
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        p {
            line-height: 20px; /* within paragraph */
            margin-bottom: 8px; /* between paragraphs */
        }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body class="h-full bg-violet-700 text-white">
<main class="bg-violet-100 text-black">
    @include('layouts.adminnavigation')
    <div class="mx-auto max-w-7xl px-4 py-6">
        <div class=" bg-white border-1 border-gray-400 rounded-xl  outline outline-1 -outline-offset-1 drop-shadow-lg outline-gray-300 pb-2">
            <div class="p-2">
                {{ $slot }}
            </div>
        </div>
    </div>
    <div class="mt-4 p-4  bg-violet-700 text-white pb-4">
        <div class="text-sm mt-2 text-center  bg-violet-700 text-white"><a href="https://oldgit.uk">©2018
                - {{date("Y")}}
                Development by Oldgit UK</a></div>
    </div>
</main>
</body>
</html>
