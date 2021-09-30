@extends('layouts.app')

@section('title', 'Edit Case')

@section('orientation', 'hk-horizontal-nav')

@section('navbardirection', 'flex-row')

@push('css')
    <!-- Toggles CSS -->
    <link href="{{ asset('vendors/jquery-toggles/css/toggles.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendors/jquery-toggles/css/themes/toggles-light.css') }}" rel="stylesheet" type="text/css">

    <!-- ION CSS -->
    <link href="{{ asset('vendors/ion-rangeslider/css/ion.rangeSlider.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendors/ion-rangeslider/css/ion.rangeSlider.skinHTML5.css') }}" rel="stylesheet"
          type="text/css">

    <!-- select2 CSS -->
    <link href="{{ asset('vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>

    <!-- Pickr CSS -->
    <link href="{{ asset('vendors/pickr-widget/dist/pickr.min.css') }}" rel="stylesheet" type="text/css"/>

    <!-- Daterangepicker CSS -->
    <link href="{{ asset('vendors/daterangepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css"/>
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

    <script src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAPS_GEOCODING_API_KEY') }}&libraries=places"
            type="text/javascript"></script>
    <script>
        google.maps.event.addDomListener(window, 'load', initialize);

        function initialize() {
            var options = {
                //types: ['(cities)'],
                componentRestrictions: {country: "ke"}
            };
            var input = document.getElementById('autocomplete');
            var autocomplete = new google.maps.places.Autocomplete(input, options);
            autocomplete.addListener('place_changed', function () {
                var place = autocomplete.getPlace();
                $('#latitude').val(place.geometry['location'].lat());
                $('#longitude').val(place.geometry['location'].lng());
            });
        }


    </script>

    <script>
        $(document).ready(function () {
            if ($('#mass-casualty-incident').length) {

                $('#mass-casualty-incident').on('change', function () {
                    var selected = $(this).find(":selected").val();
                    if (selected == 'Yes') {
                        $('.partial-block').find('input, textarea, button, select').attr('disabled', true);
                        $('.partial-block').find('input, textarea, button, select').attr('required', false);
                        $('.partial-block').hide();

                        $('.partial-block2').find('input, textarea, button, select').attr('disabled', false);
                        $('.partial-block2').find('input, textarea, button, select').attr('required', true);
                        $('.partial-block2').show();

                    } else {
                        $('.partial-block').find('input, textarea, button, select').attr('disabled', false);
                        $('.partial-block').find('input, textarea, button, select').attr('required', true);
                        $('.partial-block').show();

                        $('.partial-block2').find('input, textarea, button, select').attr('disabled', true);
                        $('.partial-block2').find('input, textarea, button, select').attr('required', false);
                        $('.partial-block2').hide();
                    }
                });
                var statusval;
                statusval = $('#mass-casualty-incident option:selected').val();


                if (statusval == 'Yes') {
                    $('.partial-block').find('input, textarea, button, select').attr('disabled', true);
                    $('.partial-block').find('input, textarea, button, select').attr('required', false);
                    $('.partial-block').hide();

                    $('.partial-block2').find('input, textarea, button, select').attr('disabled', false);
                    $('.partial-block2').find('input, textarea, button, select')
                        .not(':input[type=file]')
                        .attr('required', true);
                    $('.partial-block2').show();
                } else {
                    $('.partial-block').find('input, textarea, button, select').attr('disabled', false);
                    $('.partial-block').find('input, textarea, button, select')
                        .not(':input[type=file]')
                        .attr('required', true);
                    $('.partial-block').show();

                    $('.partial-block2').find('input, textarea, button, select').attr('disabled', true);
                    $('.partial-block2').find('input, textarea, button, select').attr('required', false);
                    $('.partial-block2').hide();
                }

            }
        });
    </script>

    <script>
        var regex = /^(.+?)(\d+)$/i;
        var cloneIndex = $(".clonedInput").length;

        if ($(".clonedInput").length == 1) {
            $('.remove').hide();
        } else {
            $('.remove').show();
        }

        function clone() {
            cloneIndex++;
            $(this).parents(".clonedInput").clone()
                .attr("id", "clonedInput" + cloneIndex)
                .find("*")
                .each(function () {
                    var id = this.id || "";
                    var match = id.match(regex) || [];
                    if (match.length == 3) {
                        this.id = match[1] + (cloneIndex);
                    }
                    $(".channel", this).attr('name', 'notifiers[' + (cloneIndex - 1) + '][channel]');
                    $(".notifier-phone", this).attr('name', 'notifiers[' + (cloneIndex - 1) + '][phone]');
                    //console.log(cloneIndex);

                }).end().appendTo(".forcloned");


            if ($(".clonedInput").length == 1) {
                $('.remove').hide();
            } else {
                $('.remove').show();
            }


        }

        function remove() {
            $(this).parents(".clonedInput").remove();

            if ($(".clonedInput").length == 1) {
                $('.remove').hide();
            } else {
                $('.remove').show();
            }

        }

        $(document).on("click", "button.clone", clone);
        $(document).on("click", "button.remove", remove);


    </script>

@endpush

@section('content')

    <!-- Container -->
    <div class="container">
        <!-- Breadcrumb -->
        <nav class="hk-breadcrumb" aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-light bg-transparent">
                <li class="breadcrumb-item"><a href="#">Cases</a></li>
                <li class="breadcrumb-item"><a href="{{ route('incidents.index') }}">Cases</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
        <!-- /Breadcrumb -->

        <!-- Title -->
        <div class="hk-pg-header">
            <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="edit-2"></i></span></span>Edit
                Case</h4>
        </div>
        <!-- /Title -->

    @include('common.flash-message')

    <!-- Row -->
        <div class="row">
            <div class="col-md-12">
                <section class="hk-sec-wrapper">
                    <h5 class="hk-sec-title">Edit Case Details</h5>
                    <form method="POST" action="{{route('incidents.update', $incident)}}" role="form">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="mass_casualty_incident">Mass Casualty Incident?</label>
                            <select name="mass_casualty_incident" id="mass-casualty-incident"
                                    class="form-control @error('mass_casualty_incident') is-invalid @enderror"
                                    required="">
                                <option value="">Select</option>
                                <option value="No" {{ 'No'==$incident->mass_casualty_incident?'selected':'' }}>No
                                </option>
                                <option value="Yes" {{ 'Yes'==$incident->mass_casualty_incident?'selected':'' }}>Yes
                                </option>
                            </select>
                            @error('mass_casualty_incident')
                            <div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label for="chief_complaint">Chief Complaint</label>
                            <textarea name="chief_complaint" rows="6"
                                      class="form-control @error('chief_complaint') is-invalid @enderror"
                                      required="">{{ $incident->chief_complaint }}</textarea>
                            @error('chief_complaint')
                            <div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label for="location">Location of incidence</label>
                            <input type="text" name="location"
                                   class="form-control @error('location') is-invalid @enderror" id="autocomplete"
                                   value="{{ $incident->location }}" required="">
                            @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>@enderror
                            <input type="hidden" name="location_lat" id="latitude" class="form-control"
                                   value="{{$location_lat ?? ''}}">
                            <input type="hidden" name="location_long" id="longitude" class="form-control"
                                   value="{{$location_long ?? ''}}">
                        </div>
                        <div class="form-group">
                            <label for="sub_county">Sub County</label>
                            <select name="sub_county" id="sub_county"
                                    class="form-control @error('sub_county') is-invalid @enderror" required="">
                                <option value="">Select Sub County</option>
                                <option value="Dagoretti" {{ 'Dagoretti'==$incident->sub_county?'selected':'' }}>
                                    Dagoretti
                                </option>
                                <option
                                    value="Embakasi East" {{ 'Embakasi East'==$incident->sub_county?'selected':'' }}>
                                    Embakasi East
                                </option>
                                <option
                                    value="Embakasi West" {{ 'Embakasi West'==$incident->sub_county?'selected':'' }}>
                                    Embakasi West
                                </option>
                                <option value="Kamukunji" {{ 'Kamukunji'==$incident->sub_county?'selected':'' }}>
                                    Kamukunji
                                </option>
                                <option value="Kasarani" {{ 'Kasarani'==$incident->sub_county?'selected':'' }}>
                                    Kasarani
                                </option>
                                <option value="Langata" {{ 'Langata '==$incident->sub_county?'selected':'' }}>Langata
                                </option>
                                <option value="Makadara" {{ 'Makadara'==$incident->sub_county?'selected':'' }}>
                                    Makadara
                                </option>
                                <option value="Ruaraka" {{ 'Ruaraka'==$incident->sub_county?'selected':'' }}>Ruaraka
                                </option>
                                <option value="Starehe" {{ 'Starehe'==$incident->sub_county?'selected':'' }}>Starehe
                                </option>
                                <option value="Westlands" {{ 'Westlands'==$incident->sub_county?'selected':'' }}>
                                    Westlands
                                </option>
                            </select>
                            @error('sub_county')
                            <div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label for="alert_mode">Mode of Alert <small>(e.g Call, SMS, Email, Radio
                                    call)</small></label>
                            <select name="alert_mode" id="alert_mode"
                                    class="form-control @error('alert_mode') is-invalid @enderror" required="">
                                <option value="">Select Mode</option>
                                <option value="Call" {{ 'Call'==$incident->alert_mode?'selected':'' }}>Call</option>
                                <option value="Email" {{ 'Email'==$incident->alert_mode?'selected':'' }}>Email</option>
                                <option value="Radio Call" {{ 'Radio Call'==$incident->alert_mode?'selected':'' }}>Radio
                                    Call
                                </option>
                                <option value="SMS" {{ 'SMS'==$incident->alert_mode?'selected':'' }}>SMS</option>
                            </select>
                            @error('alert_mode')
                            <div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label for="alert_nature">Nature of the rumor/alert <small>(e.g. Covid-19, RTA, Medical
                                    advice, Maternity cases, Public Concern etc.))</small></label>
                            <select name="alert_nature" id="alert_nature"
                                    class="form-control @error('alert_nature') is-invalid @enderror" required="">
                                <option value="">Select Nature</option>
                                <option
                                    value="Ambulance Requests" {{ 'Ambulance Requests'==$incident->alert_nature?'selected':'' }}>
                                    Ambulance Requests
                                </option>
                                <option value="Covid-19" {{ 'Covid-19'==$incident->alert_nature?'selected':'' }}>
                                    Covid-19
                                </option>
                                <option
                                    value="General inquiry" {{ 'General inquiry'==$incident->alert_nature?'selected':'' }}>
                                    General inquiry
                                </option>
                                <option
                                    value="HBIC Evacuations/Protocols" {{ 'HBIC Evacuations/Protocols'==$incident->alert_nature?'selected':'' }}>
                                    HBIC Evacuations/Protocols
                                </option>
                                <option
                                    value="JKIA Evacuations" {{ 'JKIA Evacuations'==$incident->alert_nature?'selected':'' }}>
                                    JKIA Evacuations
                                </option>
                                <option
                                    value="Maternity cases" {{ 'Maternity cases'==$incident->alert_nature?'selected':'' }}>
                                    Maternity cases
                                </option>
                                <option
                                    value="Medical Advice" {{ 'Medical Advice'==$incident->alert_nature?'selected':'' }}>
                                    Medical Advice
                                </option>
                                <option
                                    value="Public Concern" {{ 'Public Concern'==$incident->alert_nature?'selected':'' }}>
                                    Public Concern
                                </option>
                                <option value="RTA" {{ 'RTA'==$incident->alert_nature?'selected':'' }}>RTA</option>
                                <option value="Others" {{ 'Others'==$incident->alert_nature?'selected':'' }}>Others
                                </option>
                            </select>
                            @error('alert_nature')
                            <div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label for="estate_health_facility">Estate/Health Facility</label>
                            <input type="text" name="estate_health_facility"
                                   class="form-control @error('estate_health_facility') is-invalid @enderror"
                                   id="estate_health_facility" value="{{ $incident->estate_health_facility }}">
                            @error('estate_health_facility')
                            <div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <hr/>
                        <div class="forcloned">
                            @foreach ($channel_data as $key => $item)
                                <div id="clonedInput{{$loop->iteration}}" class="clonedInput">
                                    <div class="form-group">
                                        <label for="channel">Channel <small>(How was the rumor/alert heard e.g.
                                                Notifier's Name)</small></label>
                                        <input type="text" name="notifiers[{{$loop->index}}][channel]"
                                               class="form-control channel" value="{{$item}}" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="notifier_phone">Notifier's Phone Number</label>
                                        <input type="text" name="notifiers[{{$loop->index}}][phone]"
                                               class="form-control notifier-phone" value="{{$phone_data[$key]}}"
                                               required="">
                                    </div>
                                    <div class="partial-block2">
                                        <div class="form-group">
                                            <button class="clone btn btn-success" type="button"><i
                                                    class="fa fa-plus"></i></button>
                                            <button class="remove btn btn-danger" type="button"><i
                                                    class="fa fa-minus"></i></button>
                                        </div>
                                    </div>
                                    <hr/>
                                </div>
                            @endforeach
                        </div>

                        <div class="partial-block">
                            <div class="form-group">
                                <label for="patient_name">Patients Name</label>
                                <input type="text" name="patient_name"
                                       class="form-control @error('patient_name') is-invalid @enderror"
                                       id="patient_name" value="{{ $incident->patient_name }}" required="">
                                @error('patient_name')
                                <div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label for="patient_age">Patients Age</label>
                                <select name="patient_age" id="patient_age"
                                        class="form-control @error('patient_age') is-invalid @enderror" required="">
                                    <option value="">Select Age</option>
                                    @for ($i = 1; $i < 120; $i++)
                                        <option
                                            value="{{ $i }}" {{ $i==$incident->patient_age?'selected':'' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                                @error('patient_age')
                                <div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label for="patient_gender">Patients Gender</label>
                                <select name="patient_gender" id="patient_gender"
                                        class="form-control @error('patient_gender') is-invalid @enderror">
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ 'Male'==$incident->patient_gender?'selected':'' }}>Male
                                    </option>
                                    <option value="Female" {{ 'Female'==$incident->patient_gender?'selected':'' }}>
                                        Female
                                    </option>
                                </select>
                                @error('patient_gender')
                                <div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label for="patient_nhif_insurance_data">Patients NHIF / Insurance data</label>
                                <input type="text" name="patient_nhif_insurance_data"
                                       class="form-control @error('patient_nhif_insurance_data') is-invalid @enderror"
                                       id="patient_nhif_insurance_data"
                                       value="{{ $incident->patient_nhif_insurance_data }}">
                                @error('patient_nhif_insurance_data')
                                <div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label for="patient_contact">Patient Phone/contact </label>
                                <input type="text" name="patient_contact"
                                       class="form-control @error('patient_contact') is-invalid @enderror"
                                       id="patient_contact" value="{{ $incident->patient_contact }}">
                                @error('patient_contact')
                                <div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label for="patient_next_of_kin">Patient Next of Kin </label>
                                <input type="text" name="patient_next_of_kin"
                                       class="form-control @error('patient_next_of_kin') is-invalid @enderror"
                                       id="patient_next_of_kin" value="{{ $incident->patient_next_of_kin }}">
                                @error('patient_next_of_kin')
                                <div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="partial-block2">
                            <div class="form-group">
                                <label for="mass_casualty_cases">Cases <small>(Number of casualties)</small></label>
                                <input type="number" name="mass_casualty_cases"
                                       class="form-control @error('mass_casualty_cases') is-invalid @enderror"
                                       id="mass_casualty_cases" value="{{ $incident->mass_casualty_cases }}">
                                @error('mass_casualty_cases')
                                <div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="watcher_comments">Comments</label>
                            <textarea name="watcher_comments" rows="6"
                                      class="form-control @error('watcher_comments') is-invalid @enderror">{{ $incident->watcher_comments }}</textarea>
                            @error('watcher_comments')
                            <div class="invalid-feedback">{{ $message }}</div>@enderror
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
