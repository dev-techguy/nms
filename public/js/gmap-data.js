/*Gmap Init*/

"use strict";

/* Map initialization js*/
if ($('#map_canvas').length > 0) {
    // When the window has finished loading create our google map below
    google.maps.event.addDomListener(window, 'load', initAutocomplete);

    function init() {
        var nairobi = {
            info: '<strong>Welcome to nairobi</strong>',
            lat: -1.286389,
            long: 36.817223
        };



        var locations = [
            [nairobi.info, nairobi.lat, nairobi.long, 0],
        ];
        // Basic options for a simple Google Map
        // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
        var mapOptions = {
            // How zoomed in you want the map to start at (always required)
            zoom: 11,

            // The latitude and longitude to center the map (always required)
            center: new google.maps.LatLng(-1.286389, 36.817223), // nairobi

            // How you would like to style the map. 
            // This is where you would paste any style found on Snazzy Maps.
            styles: [
                {
                    "featureType": "administrative",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#444444"
                        }
                    ]
                },
                {
                    "featureType": "administrative.locality",
                    "elementType": "labels",
                    "stylers": [
                        {
                            "visibility": "on"
                        }
                    ]
                },
                {
                    "featureType": "landscape",
                    "elementType": "all",
                    "stylers": [
                        {
                            "color": "#f2f2f2"
                        },
                        {
                            "visibility": "simplified"
                        }
                    ]
                },
                {
                    "featureType": "poi",
                    "elementType": "all",
                    "stylers": [
                        {
                            "visibility": "on"
                        }
                    ]
                },
                {
                    "featureType": "poi",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "visibility": "simplified"
                        },
                        {
                            "saturation": "-65"
                        },
                        {
                            "lightness": "45"
                        },
                        {
                            "gamma": "1.78"
                        }
                    ]
                },
                {
                    "featureType": "poi",
                    "elementType": "labels",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "poi",
                    "elementType": "labels.icon",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "road",
                    "elementType": "all",
                    "stylers": [
                        {
                            "saturation": -100
                        },
                        {
                            "lightness": 45
                        }
                    ]
                },
                {
                    "featureType": "road",
                    "elementType": "labels",
                    "stylers": [
                        {
                            "visibility": "on"
                        }
                    ]
                },
                {
                    "featureType": "road",
                    "elementType": "labels.icon",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "all",
                    "stylers": [
                        {
                            "visibility": "simplified"
                        }
                    ]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "labels.icon",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "road.arterial",
                    "elementType": "labels.icon",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "transit.line",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "saturation": "-33"
                        },
                        {
                            "lightness": "22"
                        },
                        {
                            "gamma": "2.08"
                        }
                    ]
                },
                {
                    "featureType": "transit.station.airport",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "gamma": "2.08"
                        },
                        {
                            "hue": "#ffa200"
                        }
                    ]
                },
                {
                    "featureType": "transit.station.airport",
                    "elementType": "labels",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "transit.station.rail",
                    "elementType": "labels.text",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "transit.station.rail",
                    "elementType": "labels.icon",
                    "stylers": [
                        {
                            "visibility": "simplified"
                        },
                        {
                            "saturation": "-55"
                        },
                        {
                            "lightness": "-2"
                        },
                        {
                            "gamma": "1.88"
                        },
                        {
                            "hue": "#ffab00"
                        }
                    ]
                },
                {
                    "featureType": "water",
                    "elementType": "all",
                    "stylers": [
                        {
                            "color": "#bbd9e5"
                        },
                        {
                            "visibility": "simplified"
                        }
                    ]
                }
            ]};

        // Get the HTML DOM element that will contain your map 
        // We are using a div with id="map" seen below in the <body>
        var mapElement = document.getElementById('map_canvas');

        // Create the Google Map using our element and options defined above
        var map = new google.maps.Map(mapElement, mapOptions);
        var contentString = '<div class="infowindow-wrap">' +
                '<h5 class="infowindow-header">Nairobi Metropolitan Services</h5>' +
                '<div class="infowindow-body"><p class="txt-dark mb-15">Test, <br>Test, Kenya</p><a href="#" target="_blank">www.test.com</a></div>' +
                '</div>';
        var infowindow = new google.maps.InfoWindow({
            content: contentString
        });
        var marker, i;
        // Let's also add a marker while we're at it
        for (i = 0; i < locations.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map,
            });

            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                if (i === 2) {
                    return false;
                } else
                    return function () {
                        infowindow.open(map, marker);
                    }
            })(marker, i));
            new google.maps.event.trigger(marker, 'click');
        }



    }


    // This example adds a search box to a map, using the Google Place Autocomplete
    // feature. People can enter geographical searches. The search box will return a
    // pick list containing a mix of places and predicted search terms.
    // This example requires the Places library. Include the libraries=places
    // parameter when you first load the API. For example:
    // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
    function initAutocomplete() {
        var nairobi = {
            info: '<strong>Welcome to nairobi</strong>',
            lat: -1.286389,
            long: 36.817223
        };
        /*var kiambu = {
            info: '<strong>Welcome to kiambu</strong>',
            lat: -1.977233,
            long: 79.638107
        };*/

        var locations = [
            [nairobi.info, nairobi.lat, nairobi.long, 0],
            //[kiambu.info, kiambu.lat, kiambu.long, 0],
        ];
        
        const map = new google.maps.Map(document.getElementById("map_canvas"), {
            center: {lat: -1.286389, lng: 36.817223},
            zoom: 13,
            mapTypeId: "roadmap",
        });
        // Create the search box and link it to the UI element.
        const input = document.getElementById("pac-input");
        const searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
        // Bias the SearchBox results towards current map's viewport.
        map.addListener("bounds_changed", () => {
            searchBox.setBounds(map.getBounds());
        });
        
        var contentString = '<div class="infowindow-wrap">' +
                '<h5 class="infowindow-header">KCY 502U</h5>' +
                '<div class="infowindow-body"></div>' +
                '</div>';
        var infowindow = new google.maps.InfoWindow({
            content: contentString
        });
        var marker, i;
        
        var iconBase = 'https://maps.google.com/mapfiles/kml/shapes/';
        // Let's also add a marker while we're at it
        for (i = 0; i < locations.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map,
                icon: iconBase + 'cabs.png'
            });

            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                if (i === 2) {
                    return false;
                } else
                    return function () {
                        infowindow.open(map, marker);
                    }
            })(marker, i));
            new google.maps.event.trigger(marker, 'click');
        }
        
        /*let markers = [];*/
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener("places_changed", () => {
            const places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            }
            // Clear out the old markers.
            /*markers.forEach((marker) => {
                marker.setMap(null);
            });
            markers = [];*/
            // For each place, get the icon, name and location.
            const bounds = new google.maps.LatLngBounds();
            places.forEach((place) => {
                if (!place.geometry || !place.geometry.location) {
                    console.log("Returned place contains no geometry");
                    return;
                }
                const icon = {
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25),
                };
                // Create a marker for each place.
                /*markers.push(
                        new google.maps.Marker({
                            map,
                            icon,
                            title: place.name,
                            position: place.geometry.location,
                        })
                        );*/

                if (place.geometry.viewport) {
                    // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
            });
            map.fitBounds(bounds);
        });
        
    }
}

