@extends('layouts.app')

@section('title', 'Edit Facility')

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

@endpush

@section('content')

<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Facilities</a></li>
        <li class="breadcrumb-item"><a href="{{ route('facilities.index') }}">Facilities</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

<!-- Container -->
<div class="container">
    <!-- Title -->
    <div class="hk-pg-header">
        <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="edit-2"></i></span></span>Edit Facility</h4>
    </div>
    <!-- /Title -->

    @include('common.flash-message')

    <!-- Row -->
    <div class="row">
        <div class="col-md-12">
            <section class="hk-sec-wrapper">
                <h5 class="hk-sec-title">Edit Facility Details</h5>
                <form method="POST" action="{{route('facilities.update', $editData)}}" role="form">
                    @method('PUT')
                    @csrf

                    <div class="form-group" {{ $errors->has('title') ? 'has-error' : '' }}>
                        <label for="title">Name</label>
                        <input id="title" name="title" type="text" class="form-control" value="{{$editData->title}}" required>
                        @if($errors->has('title'))
                        <p class="help-block">
                            {{ $errors->first('title') }}
                        </p>
                        @endif
                    </div>
                    <div class="form-group" {{ $errors->has('keph_level') ? 'has-error' : '' }}>
                        <label for="keph_level">Level</label>
                        <select class="form-control" id="keph_level" name="keph_level" required>
                            <option value="">-- Select Level --</option>
                            <option value="Level 1" {{ $editData->keph_level == "Level 1" ? 'selected' : '' }}>Level 1</option>
                            <option value="Level 2" {{ $editData->keph_level == "Level 2" ? 'selected' : '' }}>Level 2</option>
                            <option value="Level 3" {{ $editData->keph_level == "Level 3" ? 'selected' : '' }}>Level 3</option>
                            <option value="Level 4" {{ $editData->keph_level == "Level 4" ? 'selected' : '' }}>Level 4</option>
                            <option value="Level 5" {{ $editData->keph_level == "Level 5" ? 'selected' : '' }}>Level 5</option>
                            <option value="Level 6" {{ $editData->keph_level == "Level 6" ? 'selected' : '' }}>Level 6</option>
                        </select>
                        @if($errors->has('keph_level'))
                        <p class="help-block">
                            {{ $errors->first('keph_level') }}
                        </p>
                        @endif
                    </div>
                    <div class="form-group" {{ $errors->has('type') ? 'has-error' : '' }}>
                        <label for="type">Facility Type</label>
                        <select class="form-control" id="type" name="type" required>
                            <option value="">-- Select Type --</option>
                            <option value="Comprehensive health Centre" {{ $editData->type == "Comprehensive health Centre" ? 'selected' : '' }}>Comprehensive health Centre</option>
                            <option value="Comprehensive Teaching & Tertiary Referral Hospital" {{ $editData->type == "Comprehensive Teaching & Tertiary Referral Hospital" ? 'selected' : '' }}>Comprehensive Teaching & Tertiary Referral Hospital</option>
                            <option value="Primary care hospitals" {{ $editData->type == "Primary care hospitals" ? 'selected' : '' }}>Primary care hospitals</option>
                            <option value="Specialized & Tertiary Referral hospitals" {{ $editData->type == "Specialized & Tertiary Referral hospitals" ? 'selected' : '' }}>Specialized & Tertiary Referral hospitals</option>
                            <option value="Secondary care hospitals" {{ $editData->type == "Secondary care hospitals" ? 'selected' : '' }}>Secondary care hospitals</option>

                        </select>
                        @if($errors->has('type'))
                        <p class="help-block">
                            {{ $errors->first('type') }}
                        </p>
                        @endif
                    </div>
                    <div class="form-group" {{ $errors->has('category') ? 'has-error' : '' }}>
                        <label for="category">Facility Category</label>
                        <select class="form-control" id="category" name="category" required>
                            <option value="">-- Select category --</option>
                            <option value="MEDICAL CENTER" {{ $editData->category == "MEDICAL CENTER" ? 'selected' : '' }}>MEDICAL CENTER</option>
                            <option value="MEDICAL CLINIC" {{ $editData->category == "MEDICAL CLINIC" ? 'selected' : '' }}>MEDICAL CLINIC</option>
                            <option value="NURSING HOME" {{ $editData->category == "NURSING HOME" ? 'selected' : '' }}>NURSING HOME</option>
                            <option value="HOSPITALS" {{ $editData->category == "HOSPITALS" ? 'selected' : '' }}>HOSPITALS</option>
                            <option value="STAND ALONE" {{ $editData->category == "STAND ALONE" ? 'selected' : '' }}>STAND ALONE</option>
                            <option value="HEALTH CENTRE" {{ $editData->category == "HEALTH CENTRE" ? 'selected' : '' }}>HEALTH CENTRE</option>
                            <option value="DISPENSARY" {{ $editData->category == "DISPENSARY" ? 'selected' : '' }}>DISPENSARY</option>
                            <option value="Primary health  care services" {{ $editData->category == "Primary health  care services" ? 'selected' : '' }}>Primary health  care services</option>
                        </select>
                        @if($errors->has('category'))
                        <p class="help-block">
                            {{ $errors->first('category') }}
                        </p>
                        @endif
                    </div>
                    <div class="form-group" {{ $errors->has('ownership') ? 'has-error' : '' }}>
                        <label for="ownership">Ownership</label>
                        <select class="form-control" id="ownership" name="ownership" required>
                            <option value="">-- Select ownership type --</option>
                            <option value="Private" {{ $editData->ownership == "Private" ? 'selected' : '' }}>Private Practice</option>
                            <option value="MOH" {{ $editData->ownership == "MOH" ? 'selected' : '' }}>Ministry of Health</option>
                            <option value="FBO" {{ $editData->ownership == "FBO" ? 'selected' : '' }}>Faith Based Organization</option>
                            <option value="NGO" {{ $editData->ownership == "NGO" ? 'selected' : '' }}>Non-Governmental Organizations</option>
                        </select>
                        @if($errors->has('ownership'))
                        <p class="help-block">
                            {{ $errors->first('ownership') }}
                        </p>
                        @endif
                    </div>
                    <div class="form-group" {{ $errors->has('regulatory_body') ? 'has-error' : '' }}>
                        <label for="regulatory_body">Regulatory Body</label>
                        <select class="form-control" id="regulatory_body" name="regulatory_body" required>
                            <option value="None" {{ $editData->regulatory_body == "None" ? 'selected' : '' }}>-- Select regulatory body --</option>
                            <option value="Kenya MPDB" {{ $editData->regulatory_body == "Kenya MPDB" ? 'selected' : '' }}>Kenya MPDB</option>
                            <option value="Ministry of Health" {{ $editData->regulatory_body == "Ministry of Health" ? 'selected' : '' }}>Ministry of Health</option>

                        </select>
                        @if($errors->has('regulatory_body'))
                        <p class="help-block">
                            {{ $errors->first('regulatory_body') }}
                        </p>
                        @endif
                    </div>
                    <div class="form-group" {{ $errors->has('contact') ? 'has-error' : '' }}>
                        <label for="contact">Contact</label>
                        <input id="contact" name="contact" type="text" class="form-control" value="{{$editData->contact}}" required>
                        @if($errors->has('contact'))
                        <p class="help-block">
                            {{ $errors->first('contact') }}
                        </p>
                        @endif
                    </div>
                    <div class="form-group" {{ $errors->has('county') ? 'has-error' : '' }}>
                        <label for="county">County</label>
                        <input id="county" name="county" type="text" class="form-control" value="{{$editData->county}}" required>
                        @if($errors->has('county'))
                        <p class="help-block">
                            {{ $errors->first('county') }}
                        </p>
                        @endif
                    </div>
                    <div class="form-group" {{ $errors->has('constituency') ? 'has-error' : '' }}>
                        <label for="constituency">Constituency</label>
                        <input id="constituency" name="constituency" type="text" class="form-control" value="{{$editData->constituency}}" required>
                        @if($errors->has('constituency'))
                        <p class="help-block">
                            {{ $errors->first('constituency') }}
                        </p>
                        @endif
                    </div>
                    <div class="form-group" {{ $errors->has('ward') ? 'has-error' : '' }}>
                        <label for="ward">Ward</label>
                        <input id="ward" name="ward" type="text" class="form-control" value="{{$editData->ward}}" required>
                        @if($errors->has('ward'))
                        <p class="help-block">
                            {{ $errors->first('ward') }}
                        </p>
                        @endif
                    </div>
                    <div class="form-group" {{ $errors->has('location') ? 'has-error' : '' }}>
                        <label for="location">Physical Address</label>
                        <input id="location" name="location" type="text" class="form-control" value="{{$editData->location}}" required>
                        @if($errors->has('location'))
                        <p class="help-block">
                            {{ $errors->first('location') }}
                        </p>
                        @endif
                    </div>
                    <!--
                    <div class="form-group" {{ $errors->has('latitude') ? 'has-error' : '' }}>
                        <label for="latitude">Latitude</label>
                        <input id="latitude" name="latitude" type="text" class="form-control" value="{{$editData->latitude}}" >
                        @if($errors->has('latitude'))
                            <p class="help-block">
                                {{ $errors->first('latitude') }}
                            </p>
                        @endif
                    </div>
                    <div class="form-group" {{ $errors->has('longitude') ? 'has-error' : '' }}>
                        <label for="longitude">Longitude</label>
                        <input id="longitude" name="longitude" type="text" class="form-control" value="{{$editData->longitude}}" >
                        @if($errors->has('longitude'))
                            <p class="help-block">
                                {{ $errors->first('longitude') }}
                            </p>
                        @endif
                    </div> -->
                    <div class="form-group" {{ $errors->has('open_whole_day') ? 'has-error' : '' }}>
                        <label for="open_whole_day">Open whole day</label>
                        <select class="form-control" id="open_whole_day" name="open_whole_day" required>
                            <option value="">-- Select --</option>
                            <option value="Yes" {{ $editData->open_whole_day == "Yes" ? 'selected' : '' }}>Yes</option>
                            <option value="No" {{ $editData->open_whole_day == "No" ? 'selected' : '' }}>No</option>
                        </select>
                        @if($errors->has('open_whole_day'))
                        <p class="help-block">
                            {{ $errors->first('open_whole_day') }}
                        </p>
                        @endif
                    </div>
                    <div class="form-group" {{ $errors->has('open_late_night') ? 'has-error' : '' }}>
                        <label for="open_late_night">Open late night</label>
                        <select class="form-control" id="open_late_night" name="open_late_night" required>
                            <option value="">-- Select --</option>
                            <option value="Yes" {{ $editData->open_late_night == "Yes" ? 'selected' : '' }}>Yes</option>
                            <option value="No" {{ $editData->open_late_night == "No" ? 'selected' : '' }}>No</option>
                        </select>
                        @if($errors->has('open_late_night'))
                        <p class="help-block">
                            {{ $errors->first('open_late_night') }}
                        </p>
                        @endif
                    </div>
                    <div class="form-group" {{ $errors->has('open_weekends') ? 'has-error' : '' }}>
                        <label for="open_weekends">Open on weekends</label>
                        <select class="form-control" id="open_weekends" name="open_weekends" required>
                            <option value="">-- Select --</option>
                            <option value="Yes" {{ $editData->open_weekends == "Yes" ? 'selected' : '' }}>Yes</option>
                            <option value="No" {{ $editData->open_weekends == "No" ? 'selected' : '' }}>No</option>
                        </select>
                        @if($errors->has('open_weekends'))
                        <p class="help-block">
                            {{ $errors->first('open_weekends') }}
                        </p>
                        @endif
                    </div>
                    <div class="form-group" {{ $errors->has('open_public_holiday') ? 'has-error' : '' }}>
                        <label for="open_public_holiday">Open on public holiday</label>
                        <select class="form-control" id="open_public_holiday" name="open_public_holiday" required>
                            <option value="">-- Select --</option>
                            <option value="Yes" {{ $editData->open_public_holiday == "Yes" ? 'selected' : '' }}>Yes</option>
                            <option value="No" {{ $editData->open_public_holiday == "No" ? 'selected' : '' }}>No</option>
                        </select>
                        @if($errors->has('open_public_holiday'))
                        <p class="help-block">
                            {{ $errors->first('open_public_holiday') }}
                        </p>
                        @endif
                    </div>
                    <div class="form-group" {{ $errors->has('status') ? 'has-error' : '' }}>
                        <label for="status">Operational status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="">-- Select --</option>
                            <option value="Operational" {{ $editData->status == "Operational" ? 'selected' : '' }}>Operational</option>
                            <option value="Nonoperational" {{ $editData->status == "Nonoperational" ? 'selected' : '' }}>Nonoperational</option>
                        </select>
                        @if($errors->has('status'))
                        <p class="help-block">
                            {{ $errors->first('status') }}
                        </p>
                        @endif
                    </div>
                    <div class="form-group" {{ $errors->has('approved') ? 'has-error' : '' }}>
                        <label for="approved">Approved</label>
                        <select class="form-control" id="approved" name="approved" required>
                            <option value="">-- Select --</option>
                            <option value="Yes" {{ $editData->approved == "Yes" ? 'selected' : '' }}>Yes</option>
                            <option value="No" {{ $editData->approved == "No" ? 'selected' : '' }}>No</option>
                        </select>
                        @if($errors->has('approved'))
                        <p class="help-block">
                            {{ $errors->first('approved') }}
                        </p>
                        @endif
                    </div>
                    <div class="form-group" {{ $errors->has('emergency_dpt') ? 'has-error' : '' }}>
                        <label for="emergency_dpt">Emergency Department</label>
                        <select class="form-control" id="emergency_dpt" name="emergency_dpt" required>
                            <option value="">-- Select --</option>
                            <option value="Yes"{{ $editData->emergency_dpt == 'Yes' ? 'selected' : '' }}>Yes</option>
                            <option value="No"{{ $editData->emergency_dpt == 'No' ? 'selected' : '' }}>No</option>
                        </select>
                        @if($errors->has('emergency_dpt'))
                        <p class="help-block">
                            {{ $errors->first('emergency_dpt') }}
                        </p>
                        @endif
                    </div>
                    <div class="form-group" {{ $errors->has('primary_response') ? 'has-error' : '' }}>
                        <label for="primary_response">Primary Response</label>
                        <select class="form-control" id="primary_response" name="primary_response" required>
                            <option value="">-- Select --</option>
                            <option value="Yes"{{ $editData->primary_response == 'Yes' ? 'selected' : '' }}>Yes</option>
                            <option value="No"{{ $editData->primary_response == 'No' ? 'selected' : '' }}>No</option>

                        </select>
                        @if($errors->has('primary_response'))
                        <p class="help-block">
                            {{ $errors->first('primary_response') }}
                        </p>
                        @endif
                    </div>
                    <div class="form-group" {{ $errors->has('inter_facility_transfer') ? 'has-error' : '' }}>
                        <label for="inter_facility_transfer">Inter Facility Transfer</label>
                        <select class="form-control" id="inter_facility_transfer" name="inter_facility_transfer" required>
                            <option value="">-- Select --</option>
                            <option value="Yes"{{ $editData->inter_facility_transfer == 'Yes' ? 'selected' : '' }}>Yes</option>
                            <option value="No"{{ $editData->inter_facility_transfer == 'No' ? 'selected' : '' }}>No</option>

                        </select>
                        @if($errors->has('inter_facility_transfer'))
                        <p class="help-block">
                            {{ $errors->first('inter_facility_transfer') }}
                        </p>
                        @endif
                    </div>
                    <div class="form-group" {{ $errors->has('trauma_care') ? 'has-error' : '' }}>
                        <label for="trauma_care">EMS for Trauma Care</label>
                        <select class="form-control" id="trauma_care" name="trauma_care" required>
                            <option value="">-- Select --</option>
                            <option value="Yes"{{ $editData->trauma_care == 'Yes' ? 'selected' : '' }}>Yes</option>
                            <option value="No"{{ $editData->trauma_care == 'No' ? 'selected' : '' }}>No</option>

                        </select>
                        @if($errors->has('trauma_care'))
                        <p class="help-block">
                            {{ $errors->first('trauma_care') }}
                        </p>
                        @endif
                    </div>
                    <div class="form-group" {{ $errors->has('stroke_care') ? 'has-error' : '' }}>
                        <label for="stroke_care">EMS for Stroke Care</label>
                        <select class="form-control" id="stroke_care" name="stroke_care" required>
                            <option value="">-- Select --</option>
                            <option value="Yes"{{ $editData->stroke_care == 'Yes' ? 'selected' : '' }}>Yes</option>
                            <option value="No"{{ $editData->stroke_care == 'No' ? 'selected' : '' }}>No</option>
                        </select>
                        @if($errors->has('stroke_care'))
                        <p class="help-block">
                            {{ $errors->first('stroke_care') }}
                        </p>
                        @endif
                    </div>
                    <div class="form-group" {{ $errors->has('heart_attacks') ? 'has-error' : '' }}>
                        <label for="heart_attacks">EMS for Heart Attack</label>
                        <select class="form-control" id="heart_attacks" name="heart_attacks" required>
                            <option value="">-- Select --</option>
                            <option value="Yes"{{ $editData->heart_attacks == 'Yes' ? 'selected' : '' }}>Yes</option>
                            <option value="No"{{ $editData->heart_attacks == 'No' ? 'selected' : '' }}>No</option>
                        </select>
                        @if($errors->has('heart_attacks'))
                        <p class="help-block">
                            {{ $errors->first('heart_attacks') }}
                        </p>
                        @endif
                    </div>
                    <div class="form-group" {{ $errors->has('theater_stats') ? 'has-error' : '' }}>
                        <label for="theater_stats">No of Theater</label>
                        <input id="theater_stats" name="theater_stats" type="text" class="form-control" value="{{$editData->theater_stats}}" required>
                        @if($errors->has('theater_stats'))
                        <p class="help-block">
                            {{ $errors->first('theater_stats') }}
                        </p>
                        @endif
                    </div>
                    <div class="form-group" {{ $errors->has('x_ray_stats') ? 'has-error' : '' }}>
                        <label for="x_ray_stats">No of X Ray machines</label>
                        <input id="x_ray_stats" name="x_ray_stats" type="text" class="form-control" value="{{$editData->x_ray_stats}}" required>
                        @if($errors->has('x_ray_stats'))
                        <p class="help-block">
                            {{ $errors->first('x_ray_stats') }}
                        </p>
                        @endif
                    </div>
                    <div class="form-group" {{ $errors->has('CT_stats') ? 'has-error' : '' }}>
                        <label for="CT_stats">No of CT Scan </label>
                        <input id="CT_stats" name="CT_stats" type="text" class="form-control" value="{{$editData->CT_stats}}" required>
                        @if($errors->has('CT_stats'))
                        <p class="help-block">
                            {{ $errors->first('CT_stats') }}
                        </p>
                        @endif
                    </div>
                    <div class="form-group" {{ $errors->has('ultra_sound_stats') ? 'has-error' : '' }}>
                        <label for="ultra_sound_stats">No of Ultra Sound </label>
                        <input id="ultra_sound_stats" name="ultra_sound_stats" type="text" class="form-control" value="{{$editData->ultra_sound_stats}}" required>
                        @if($errors->has('ultra_sound_stats'))
                        <p class="help-block">
                            {{ $errors->first('ultra_sound_stats') }}
                        </p>
                        @endif
                    </div>
                    <div class="form-group" {{ $errors->has('orthopedics_surgeons') ? 'has-error' : '' }}>
                        <label for="orthopedics_surgeons">Orthopedics Surgeons </label>
                        <select class="form-control" id="orthopedics_surgeons" name="orthopedics_surgeons" required>
                            <option value="">-- Select --</option>
                            <option value="Yes"{{ $editData->orthopedics_surgeons == 'Yes' ? 'selected' : '' }}>Yes</option>
                            <option value="No"{{ $editData->orthopedics_surgeons == 'No' ? 'selected' : '' }}>No</option>
                        </select>
                        @if($errors->has('orthopedics_surgeons'))
                        <p class="help-block">
                            {{ $errors->first('orthopedics_surgeons') }}
                        </p>
                        @endif
                    </div>
                    <div class="form-group" {{ $errors->has('neurosurgeons') ? 'has-error' : '' }}>
                        <label for="neurosurgeons_stats">Neurosurgeons </label>
                        <select class="form-control" id="neurosurgeons" name="neurosurgeons" required>
                            <option value="">-- Select --</option>
                            <option value="Yes"{{ $editData->neurosurgeons == 'Yes' ? 'selected' : '' }}>Yes</option>
                            <option value="No"{{ $editData->neurosurgeons == 'No' ? 'selected' : '' }}>No</option>
                        </select>
                        @if($errors->has('neurosurgeons'))
                        <p class="help-block">
                            {{ $errors->first('neurosurgeons') }}
                        </p>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </section>

        </div>
    </div>
    <!-- /Row -->
</div>
<!-- /Container -->

@endsection
