@extends('layouts.app')

@section('title', 'Case Responders')

@section('orientation', 'hk-horizontal-nav')

@section('navbardirection', 'flex-row')

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

    var locations = @json($vehicleList);
         //console.log(locations);
    var location_lat = {!! $case->location_lat !!};
    var location_long = {!! $case->location_long !!};

    const map = new google.maps.Map(document.getElementById("map_canvas"), {
        center: {lat: location_lat, lng: location_long},
        zoom: 11,
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
                //console.log(locations[i]['available']);
                if (locations[i]['driver_name'] && locations[i]['available']) {
                    //var driver_id = locations[i]['driver_id'];
                    var actionURL = route('tasks.store');
                    var incidentId = {!! $case->id !!};
                    

                    actionString = '<form method="POST" action="' + actionURL + '" role="form">'
                            + '<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">'
                            + '<input type="hidden" name="driver_id" value="' + locations[i]['driver_id'] + '">'
                            + '<input type="hidden" name="vehicle_id" value="' + locations[i]['vehicle_id'] + '">'
                            + '<input type="hidden" name="incident_id" value="' + incidentId + '">'
                            + '<input type="hidden" name="emt_id" value="' + locations[i]['emt_id'] + '">'
                            + '<input type="hidden" name="nurse_id" value="' + locations[i]['nurse_id'] + '">'
                            + '<input type="hidden" name="id" value="' + locations[i]['id'] + '">'
                            + '<div class="button-list">'
                            + '<button type="submit" class="btn btn-primary btn-xs"><i class="fa fa-tasks"></i> Assign Task</button>'
                            + '</div>'
                            + '</form>';
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
    }

   
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
<div class="container">
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Cases</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cases.index') }}">Cases</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dispatch</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    @include('dispatchers.single.casetitle')

    @include('common.flash-message')

    <div class="row">
        <div class="col-xl-12 pa-0">

            @include('dispatchers.single.casenav', ['active' => 'responders'])

            <div class="tab-content mt-sm-40 mt-20">

                <div class="tab-pane fade show active" role="tabpanel">
                    <section class="hk-sec-wrapper">
                        <div class="hk-pg-header align-items-top mb-0">
                            <div>
                                <h5 class="hk-sec-title">Select Responder</h5>
                            </div>
                            <div class="d-flex">
                                <a href="javascript:void(0)" id="refreshBtn" 
                                   class="btn btn-primary btn-sm btn-wth-icon icon-right">
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
                        <p class="mb-25">Click on the green vehicles to select the responders </p>

                        <div id="map_canvas" style="height: 30rem; width: 100%;"></div>
                    </section>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /Container -->

@endsection