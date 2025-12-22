<x-app-layout>
    <style>
        .text-center {
            text-align: center;
        }

        #map {
            width: 100%;
            height: 500px;
        }
    </style>
    <div id="map"></div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-AtLvoAbjtcSN2sPXAT5HHkgk97UOOVY&callback=initMap"
            async>


    </script>
    <script>
        let map, activeInfoWindow, markers = [];

        /* ----------------------------- Initialize Map ----------------------------- */
        async function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                center: {
                    lat: 52.626137,
                    lng: -2.221603,
                },
                zoom: 7
            });

            map.addListener("click", function (event) {
                mapClicked(event);
            });

            initMarkers();
        }

        /* --------------------------- Initialize Markers --------------------------- */
        function initMarkers() {
            const initialMarkers = <?php echo json_encode($sites); ?>;

            for (let index = 0; index < initialMarkers.length; index++) {
                const markerData = initialMarkers[index];

                const contentString = '<div class="font-semibold">' + markerData.site_name + '</div><div>' + markerData.site_description + '</div>';
                const marker = new google.maps.Marker({
                    position: {lat: parseFloat(markerData['lat']), lng: parseFloat(markerData['lng'])},
                    draggable: false,
                    map
                });
                markers.push(marker);

                const infowindow = new google.maps.InfoWindow({
                    label: 'Title',
                    content: contentString,
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
                    markerClicked(marker, index);
                });

                marker.addListener("dragend", (event) => {
                    markerDragEnd(event, index);
                });
            }
        }

        /* ------------------------- Handle Map Click Event ------------------------- */
        function mapClicked(event) {
            console.log(map);
            console.log(event.latLng.lat(), event.latLng.lng());
        }

        /* ------------------------ Handle Marker Click Event ----------------------- */
        function markerClicked(marker, index) {
            console.log(map);
            console.log(marker.position.lat());
            console.log(marker.position.lng());
        }

        /* ----------------------- Handle Marker DragEnd Event ---------------------- */
        function markerDragEnd(event, index) {
            console.log(map);
            console.log(event.latLng.lat());
            console.log(event.latLng.lng());
        }
    </script>
</x-app-layout>