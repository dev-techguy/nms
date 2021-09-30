@extends('layouts.app')

@section('title', 'Dispatch')

@section('orientation', 'hk-vertical-nav')


@push('css')
<!-- Toggles CSS -->
<link href="{{ asset('vendors/jquery-toggles/css/toggles.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('vendors/jquery-toggles/css/themes/toggles-light.css') }}" rel="stylesheet" type="text/css">
<style>
    .pac-card {
        margin: 10px 10px 0 0;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        background-color: #fff;
        font-family: Roboto;
    }

    #pac-container {
        padding-bottom: 12px;
        margin-right: 12px;
    }

    .pac-controls {
        display: inline-block;
        padding: 5px 11px;
    }

    .pac-controls label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
    }

    #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 400px;
    }

    #pac-input:focus {
        border-color: #4d90fe;
    }

    #title {
        color: #fff;
        background-color: #4d90fe;
        font-size: 25px;
        font-weight: 500;
        padding: 6px 12px;
    }

    #target {
        width: 345px;
    }

</style>
@endpush

@push('js')
<!-- Gmap JavaScript -->
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAPS_GEOCODING_API_KEY') }}&libraries=places"></script>
@endpush

@push('js-extended')
<script>
"use strict";

// When the window has finished loading create our google map below
google.maps.event.addDomListener(window, 'load', initAutocomplete);

function initAutocomplete() {
    /*var nairobi = {
     info: '<strong>Welcome to nairobi</strong>',
     lat: -1.286389,
     long: 36.817223
     };
     var kiambu = {
     info: '<strong>Welcome to kiambu</strong>',
     lat: -1.977233,
     long: 79.638107
     };
     var locations2 = [
     [nairobi.info, nairobi.lat, nairobi.long, 0],
     [kiambu.info, kiambu.lat, kiambu.long, 0],
     ];
     
     console.log(locations2);*/

    var locations = @json($vehicleList);
            //console.log(locations);

    const map = new google.maps.Map(document.getElementById("map_canvas"), {
        center: {lat: -1.286389, lng: 36.817223},
        zoom: 12,
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
            '<h6 class="infowindow-header"></h6>' +
            '<div class="infowindow-body"></div>' +
            '</div>';
    var infowindow = new google.maps.InfoWindow({
        content: contentString
    });
    var marker, i;

    /*var icon = {
        url: 'https://maps.google.com/mapfiles/kml/shapes/cabs.png',
        scaledSize: new google.maps.Size(25, 25), // scaled size
        origin: new google.maps.Point(0, 0), // origin
        anchor: new google.maps.Point(0, 0) // anchor
    };*/
    var icongreen = {
        url: 'https://maps.google.com/mapfiles/kml/pal4/icon62.png',
        scaledSize: new google.maps.Size(30, 30), // scaled size
        origin: new google.maps.Point(0, 0), // origin
        anchor: new google.maps.Point(0, 0) // anchor
    };
    var iconred = {
        url: 'https://maps.google.com/mapfiles/kml/pal4/icon7.png',
        scaledSize: new google.maps.Size(30, 30), // scaled size
        origin: new google.maps.Point(0, 0), // origin
        anchor: new google.maps.Point(0, 0) // anchor
    };
    // Let's also add a marker while we're at it
    for (i = 0; i < locations.length; i++) {
        //console.log(locations[i]['lat']);
        if(locations[i]['available']){
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i]['lat'], locations[i]['long']),
                map: map,
                icon: icongreen
            });
        }else{
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i]['lat'], locations[i]['long']),
                map: map,
                icon: iconred
            });
        }

        google.maps.event.addListener(marker, 'click', (function (marker, locations, i) {
            return function () {
                var actionString = '';
                
                if(locations[i]['driver_name']){
                    //var driver_vehicle_id = locations[i]['driver_vehicle_id'];
                    //var actionURL = route('tasks.create', driver_vehicle_id);
            
                    /*actionString = '<div class="button-list">'
                        + '<button type="button" class="btn btn-secondary btn-xs">View More</button>'
                        + '<a href="' + actionURL + '" class="btn btn-primary btn-xs"><i class="fa fa-tasks"></i> Assign Task</a>'
                    + '</div>';*/
                }
                contentString = '<div class="infowindow-wrap">' +
                        '<h6 class="infowindow-header">' + locations[i]['vehicle_name'] + '</h6>' +
                        '<div class="infowindow-body"><p>\
                    Driver: ' + locations[i]['driver_name'] + '</p><p>\n\
                    EMT: ' + locations[i]['emt_name'] + '</p><p>\n\
                    Nurse: ' + locations[i]['nurse_name'] + '</p><p>\n\
                    ' + actionString + '\
                 </p></div>' +
                        '</div>';
                infowindow.close(); // Close previously opened infowindow
                infowindow.setContent(contentString);
                infowindow.open(map, marker);
            }

        })(marker, locations, i));
        /*google.maps.event.addListener(marker, 'click', function(){
         contentString = '<div class="infowindow-wrap">' +
         '<h6 class="infowindow-header">' + locations[i]['vehicle_name'] +'</h6>' +
         '<div class="infowindow-body"></div>' +
         '</div>';
         infowindow.close(); // Close previously opened infowindow
         infowindow.setContent(contentString);
         infowindow.open(map, marker);
         });*/
        //new google.maps.event.trigger(marker, 'click'); //pop up marker on the first vehicle
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
            /*const icon = {
             url: place.icon,
             size: new google.maps.Size(71, 71),
             origin: new google.maps.Point(0, 0),
             anchor: new google.maps.Point(17, 34),
             scaledSize: new google.maps.Size(25, 25),
             };
             // Create a marker for each place.
             markers.push(
             new google.maps.Marker({
             map,
             icon,
             title: place.name,
             position: place.geometry.location,
             })
             );
             */
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

$(document).ready(function(){
    if( $('#refreshBtn').length > 0 ){
        $('#refreshBtn').click(function() {
            location.reload();
        });
    }	
});

var minutesLabel = document.getElementById("minutes");
var secondsLabel = document.getElementById("seconds");
var totalSeconds = 0;
setInterval(setTime, 1000);

function setTime() {
  ++totalSeconds;
  secondsLabel.innerHTML = pad(totalSeconds % 60);
  minutesLabel.innerHTML = pad(parseInt(totalSeconds / 60));
}

function pad(val) {
  var valString = val + "";
  if (valString.length < 2) {
    return "0" + valString;
  } else {
    return valString;
  }
}

</script>
@endpush

@section('content')

<!-- Container -->
<div class="container mt-xl-50 mt-sm-30 mt-15">
    <!-- Title -->
    <div class="hk-pg-header align-items-top">
        <div>
            <h2 class="hk-pg-title font-weight-600 mb-5">Dispatch</h2>
        </div>
        <div class="d-flex">
            <a href="#" id="refreshBtn" 
               class="btn btn-primary btn-wth-icon icon-right">
                <span class="btn-text">
                    Last refresh
                    <span id="minutes">00</span>:<span id="seconds">00</span>
                </span>
                <span class="icon-label">
                    <i class="fa fa-refresh"></i> 
                </span>
                
            </a>
        </div>
    </div>
    <!-- /Title -->
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <h5 class="hk-sec-title">Search Location</h5>
                <p class="mb-25">Start typing in your location in the search box below and select from the list to see the ambulance closest to the location </p>
                <div class="row">
                    <div class="col-sm">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" id="pac-input" class="form-control controls mt-15" placeholder="Search Box">

                            </div>
                        </div>
                    </div>
                </div>
                <!-- Row -->
                <div class="row">
                    <div class="col-xl-12 pa-0">

                        <div id="map_canvas" style="height: 30rem; width: 100%;"></div>
                    </div>
                </div>
                <!-- /Row -->
            </section>
        </div>
    </div>

</div>
<!-- /Container -->


@endsection
