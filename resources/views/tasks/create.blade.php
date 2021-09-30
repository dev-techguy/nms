@extends('layouts.app')

@section('title', 'Add New Task')

@section('orientation', 'hk-vertical-nav')

@push('css')
<!-- Toggles CSS -->
<link href="{{ asset('vendors/jquery-toggles/css/toggles.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('vendors/jquery-toggles/css/themes/toggles-light.css') }}" rel="stylesheet" type="text/css">

<!-- ION CSS -->
<link href="{{ asset('vendors/ion-rangeslider/css/ion.rangeSlider.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('vendors/ion-rangeslider/css/ion.rangeSlider.skinHTML5.css') }}" rel="stylesheet" type="text/css">

<!-- select2 CSS -->
<link href="{{ asset('vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Pickr CSS -->
<link href="{{ asset('vendors/pickr-widget/dist/pickr.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Daterangepicker CSS -->
<link href="{{ asset('vendors/daterangepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('js')
<!-- Jasny-bootstrap  JavaScript -->
<script src="{{ asset('vendors/jasny-bootstrap/dist/js/jasny-bootstrap.min.js') }}"></script>

<!-- Ion JavaScript -->
<script src="{{ asset('vendors/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
<script src="{{ asset('js/rangeslider-data.js') }}"></script>

<!-- Select2 JavaScript -->
<script src="{{ asset('vendors/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('js/select2-data.js') }}"></script>

<!-- Bootstrap Tagsinput JavaScript -->
<script src="{{ asset('vendors/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>

<!-- Bootstrap Input spinner JavaScript -->
<script src="{{ asset('vendors/bootstrap-input-spinner/src/bootstrap-input-spinner.js') }}"></script>
<script src="{{ asset('js/inputspinner-data.js') }}"></script>

<!-- Pickr JavaScript -->
<script src="{{ asset('vendors/pickr-widget/dist/pickr.min.js') }}"></script>
<script src="{{ asset('js/pickr-data.js') }}"></script>

<!-- Daterangepicker JavaScript -->
<script src="{{ asset('vendors/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('vendors/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('js/daterangepicker-data.js') }}"></script>

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


</script>

@endpush

@section('content')

<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Tasks</a></li>
        <li class="breadcrumb-item"><a href="{{ route('tasks.index') }}">Tasks</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

<!-- Container -->
<div class="container">
    <!-- Title -->
    <div class="hk-pg-header">
        <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="plus"></i></span></span>Add New Task</h4>
    </div>
    <!-- /Title -->

    @include('common.flash-message')

    <!-- Row -->
    <div class="row">
        <div class="col-md-12">
            <section class="hk-sec-wrapper">
                <h5 class="hk-sec-title">Create New Task</h5>
                <form method="POST" action="{{route('tasks.store', $id)}}" role="form">
                    @csrf

                    <div class="form-group">
                        <label for="driver_id">Driver</label>
                        <input type="text" name="driver_id" class="form-control @error('driver_id') is-invalid @enderror" id="driver_id" value="{{ $driver_vehicle->driver->name }}" required=""  readonly>
                        @error('driver_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="vehicle_id">Vehicle</label>
                        <input type="text" name="vehicle_id" class="form-control @error('vehicle_id') is-invalid @enderror" id="vehicle_id" value="{{ $driver_vehicle->vehicle->registration_number }}" required=""  readonly>
                        @error('vehicle_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="emergency_location">Emergency Location</label>
                        <input type="text" name="emergency_location" class="form-control @error('emergency_location') is-invalid @enderror" id="autocomplete" value="{{ old('emergency_location') }}" required="">
                        @error('emergency_location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <input type="hidden" name="latitude" id="latitude" class="form-control" value="{{$latitude ?? ''}}">
                        <input type="hidden" name="longitude" id="longitude" class="form-control" value="{{$longitude ?? ''}}">
                    </div>
                    <div class="form-group">
                        <label for="emergency_facility_id">Emergency Center</label>
                        <select name="emergency_facility_id" id="emergency_facility_id" class="form-control @error('emergency_facility_id') is-invalid @enderror" required="">
                            <option value="">Select Emergency Center</option>
                            @foreach ($facilities as $item)
                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                            @endforeach
                        </select>
                        @error('emergency_facility_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="task_name">Task</label>
                        <textarea name="task_name" rows="6" class="form-control @error('name') is-invalid @enderror" required="">{{ old('task_name') }}</textarea>
                        @error('task_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>


                    <button type="submit" class="btn btn-primary">Send Task</button>
                </form>
            </section>

        </div>
    </div>
    <!-- /Row -->
</div>
<!-- /Container -->

@endsection
