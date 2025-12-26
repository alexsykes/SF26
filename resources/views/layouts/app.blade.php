<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Slope soaring site and weather information.">
    <meta name="keywords"
          content="UK Slope soaring, Model flying, radio control soaring">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SlopeFinder UK') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <!-- Scripts -->
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

        function onClick(direction) {
            // console.log("Direction: " + direction);
            fetch(url, {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": token
                },
                method: 'post',
                credentials: "same-origin",
                body: JSON.stringify({
                    direction: direction,
                })

            })

                // end of fetch request

                // .then(response => {
                //     if (!response.ok) {
                //         throw new Error('Network response was not ok');
                //     }
                //     console.log("Response: " + response.json());
                // })

                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    const contentType = response.headers.get('content-type');
                    console.log("ContentType: " + contentType);
                    if (contentType && contentType.includes('application/json')) {
                        console.log(response.json()); // Decode as JSON
                    } else {
                        throw new Error('Response is not JSON');
                    }
                })

                .then((data) => {
                    console.log("Response: " + data);
                    // window.location.href = redirect;
                })
                .catch(function (error) {
                    console.log(error);
                });
        }

        function clearMap() {
            for (var i = 0; i < markers.length; i++) {
                marker = markers[i];
                marker.setMap(null);
            }
        }

        async function initMarkers(initialMarkers) {
            const {Map} = await google.maps.importLibrary("maps");
            const {AdvancedMarkerElement} = (await google.maps.importLibrary('marker'));

            clearMap();

            for (let index = 0; index < initialMarkers.length; index++) {
                const markerData = initialMarkers[index];
                const siteURL = "<?php echo config('app.url'); ?>" + "/site/detail/" + markerData.id;

                const windyURL = 'https://www.windy.com/?' + markerData.lat + "," + markerData.lng + ",14";
                console.log(windyURL);
                const headerContent = markerData.site_name + ' ('
                    + markerData.begin + ' - '
                    + markerData.end
                    + ')';
                const contentString = '<div>' + markerData.site_description + '</div>'
                    + '<div><br><a class="font-semibold pt-4 underline" href="' + siteURL + '">Full details - click here</a> <br><br> <a class="font-semibold pt-4 underline" href="' + windyURL + '" target=\"_blank\">Windy forecast - click here</a></div>'
                ;
                const marker = new AdvancedMarkerElement({
                    position: {lat: parseFloat(markerData['lat']), lng: parseFloat(markerData['lng'])},
                    draggable: false,
                    map
                });
                markers.push(marker);

                const infowindow = new google.maps.InfoWindow({
                    label: 'Title',
                    content: contentString,
                    headerContent: headerContent,
                });
                marker.addListener("click", (event) => {
                    if (activeInfoWindow) {
                        activeInfoWindow.close();
                    }
                    infowindow.open({
                        anchor: marker,
                        shouldFocus: false,
                        map
                    });
                    activeInfoWindow = infowindow;
                    // markerClicked(marker, index);
                });
            }
        }

        async function getData(direction) {
            let url = '/fetchSites';
            let redirect = '/sitemap';
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            try {
                const response = await fetch(url, {
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json, text-plain, */*",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": token
                    },
                    method: 'post',
                    credentials: "same-origin",
                    body: JSON.stringify({
                        direction: direction,
                    })

                });
                if (!response.ok) {
                    throw new Error(`Response status: ${response.status}`);
                }

                const result = await response.json();
                // addMarkers(result);
                initMarkers(result);
                // console.log(result);
            } catch (error) {
                console.error(error.message);
            }
        }
    </script>
</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100">
    @include('layouts.navigation')

    <!-- Page Heading -->
    @isset($header)
        <header class="bg-white shadow">
            <div class=" mx-auto py-2  px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endisset
    <!-- Page Content -->

    <main>
        {{ $slot }}
    </main>
    <x-bottom-nav></x-bottom-nav>
</div>
</body>
</html>
