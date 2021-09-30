@extends('layouts.app')

@section('title', 'Dispatch')

@section('orientation', 'hk-vertical-nav')

@push('css')
<!-- Data Table CSS -->
<link href="{{ asset('vendors/datatables.net-dt/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('vendors/datatables.net-responsive-dt/css/responsive.dataTables.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Toggles CSS -->
<link href="{{ asset('vendors/jquery-toggles/css/toggles.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('vendors/jquery-toggles/css/themes/toggles-light.css') }}" rel="stylesheet" type="text/css">
@endpush

@push('js')
<!-- Data Table JavaScript -->
<script src="{{ asset('vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendors/datatables.net-dt/js/dataTables.dataTables.min.js') }}"></script>
<script src="{{ asset('vendors/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('vendors/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendors/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('vendors/jszip/dist/jszip.min.js') }}"></script>
<script src="{{ asset('vendors/pdfmake/build/pdfmake.min.js') }}"></script>
<script src="{{ asset('vendors/pdfmake/build/vfs_fonts.js') }}"></script>
<script src="{{ asset('vendors/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('vendors/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('js/dataTables-data.js') }}"></script>

<script src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAPS_GEOCODING_API_KEY') }}&libraries=places" type="text/javascript"></script>
<script>
    google.maps.event.addDomListener(window, 'load', initialize);
    function initialize() {
        var options = {
            //types: ['(cities)'],
            componentRestrictions: {country: "ke"}
        };
        var input = document.getElementById('autocomplete');
        var autocomplete = new google.maps.places.Autocomplete(input, options);
        autocomplete.addListener('place_changed', function() {
            var place = autocomplete.getPlace();
            $('#latitude').val(place.geometry['location'].lat());
            $('#longitude').val(place.geometry['location'].lng());
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
<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Dispatch</a></li>
        <li class="breadcrumb-item active" aria-current="page">List</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

<!-- Container -->
<div class="container">

    <!-- Title -->
    <div class="hk-pg-header">
        <div>
            <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="list"></i></span></span>Dispatch</h4>
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
    
     @include('common.flash-message')
    
    <!-- Row -->
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <h5 class="hk-sec-title">Search Location</h5>
                <p class="mb-5">Start typing in your location in the search box below and select from the list to see the ambulance closest to the location </p>
                <div class="row">
                    <div class="col-sm mb-30">
                        <form method="GET" action="{{route('dispatch.list')}}" role="form">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="autocomplete" id="autocomplete" class="form-control mt-15" value="{{$address}}" placeholder="Select Location">
                                    <input type="hidden" name="latitude" id="latitude" class="form-control" value="{{$latitude}}">
                                    <input type="hidden" name="longitude" id="longitude" class="form-control" value="{{$longitude}}">

                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-success mt-15"> Submit </button>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap">
                            <table id="datable_1" class="table table-sm w-100 pb-30">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Vehicle</th>
                                        <th>Driver</th>
                                        <th>Phone</th>
                                        <th>Distance(KM)</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($vehicleData as $item)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$item['data']['vehicle_name']}}</td>
                                        <td>{{$item['data']['driver_name']}}</td>
                                        <td>{{$item['data']['driver_phone']}}</td>
                                        <td>{{$item['distance']}}</td>
                                        <td>
                                            @if($item['data']['driver_name'])
                                            <a href="#" class="btn btn-secondary btn-xs"><i class="fa fa-search"></i> View More</a>
                                            <a href="{{ route('tasks.create', $item['data']['driver_vehicle_id']) }}" class="btn btn-primary btn-xs"><i class="fa fa-tasks"></i> Assign Task</a>
                                            @else
                                            ---
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                               
                            </table>
                        </div>
                    </div>
                </div>
            </section>
            
        </div>
    </div>
    <!-- /Row -->

</div>
<!-- /Container -->

@endsection
