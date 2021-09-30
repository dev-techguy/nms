@extends('layouts.app')

@section('title', 'View Case')

@section('orientation', 'hk-horizontal-nav')

@section('navbardirection', 'flex-row')

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

<!-- Container -->
<div class="container">

    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Cases</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cases.index') }}">Cases</a></li>
            <li class="breadcrumb-item active" aria-current="page">View</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Title -->
    <div class="hk-pg-header">
        <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="magnifier"></i></span></span>View Case</h4>
    </div>
    <!-- /Title -->

    @include('common.flash-message')

    <div class="row">
        <div class="col-xl-12 pa-0">

            <section class="hk-sec-wrapper">
                <div class="row mb-25">
                    <div class="form-group col-sm-4">
                        <label>Chief Complaint:</label>
                        <p>{{$case->chief_complaint}}</p>
                    </div>
                    <div class="form-group col-sm-4">
                        <label>Location of incidence:</label>
                        <p>{{$case->location}}</p>
                    </div>
                    <div class="form-group col-sm-4">
                        <label>Sub County:</label>
                        <p>{{$case->sub_county}}</p>
                    </div>
                </div>
                <div class="row mb-25">
                    <div class="form-group col-sm-4">
                        <label>Mode of Alert:</label>
                        <p>{{$case->alert_mode}}</p>
                    </div>
                    <div class="form-group col-sm-4">
                        <label>Channel:</label>
                        <p>{{$case->channel}}</p>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="notifier_phone">Notifier's Phone Number</label>
                        <p>{{$case->notifier_phone}}</p>
                    </div>
                </div>
                <div class="row mb-25">
                    <div class="form-group col-sm-4">
                        <label for="alert_nature">Nature of the rumor/alert <small>(e.g. Covid-19, RTA, Medical advice, Maternity cases, Public Concern etc.))</small></label>
                        <p>{{$case->alert_nature}}</p>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="estate_health_facility">Estate/Health Facility</label>
                        <p>{{$case->estate_health_facility}}</p>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="patient_name">Patients Name</label>
                        <p>{{$case->patient_name}}</p>
                    </div>
                </div>
                <div class="row mb-25">
                    <div class="form-group col-sm-4">
                        <label for="patient_age">Patients Age</label>
                        <p>{{$case->patient_age}}</p>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="patient_gender">Patients Gender</label>
                        <p>{{$case->patient_gender}}</p>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="patient_nhif_insurance_data">Patients NHIF / Insurance data</label>
                        <p>{{$case->patient_nhif_insurance_data}}</p>
                    </div>
                </div>
                <div class="row mb-25">
                    <div class="form-group col-sm-4">
                        <label for="patient_contact">Patient Phone/contact </label>
                        <p>{{$case->patient_contact}}</p>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="patient_next_of_kin">Patient Next of Kin </label>
                        <p>{{$case->patient_next_of_kin}}</p>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="mass_casualty_incident">Mass Casualty Incident?</label>
                        <p>{{$case->mass_casualty_incident}}</p>
                    </div>
                </div>
                <div class="row mb-25">
                    <div class="form-group col-sm-4">
                        <label for="mass_casualty_incident">Mass Casualty Cases</label>
                        <p>{{$case->mass_casualty_cases}}</p>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="watcher_comments">Watcher Comments</label>
                        <p>{{$case->watcher_comments}}</p>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="dispatcher_comments">Dispatcher Comments</label>
                        <p>{{$case->dispatcher_comments}}</p>
                    </div>
                </div>
                   
            </section>

        </div>
    </div>



</div>
<!-- /Container -->

@endsection