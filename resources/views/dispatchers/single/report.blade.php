@extends('layouts.app')

@section('title', 'Case Report')

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
            <li class="breadcrumb-item active" aria-current="page">Report</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    @include('dispatchers.single.casetitle')

    @include('common.flash-message')

    <div class="row">
        <div class="col-xl-12 pa-0">

            @include('dispatchers.single.casenav', ['active' => 'report'])

            <div class="tab-content mt-sm-40 mt-20">

                <div class="tab-pane fade show active" role="tabpanel">
                    <!-- Row -->
                    <div class="row">
                        <div class="col-md-6">
                            <section class="hk-sec-wrapper">
                                <h5 class="hk-sec-title">Report</h5>
                                <form method="POST" action="{{route('cases.dispatch.store.report', $case)}}" role="form">
                                    @csrf
                                    <div class="form-group">
                                        <label for="dispatcher_challenges">Challenges</label>
                                        <textarea name="dispatcher_challenges" rows="6" class="form-control @error('dispatcher_challenges') is-invalid @enderror" required="">{{ $case->dispatcher_challenges }}</textarea>
                                        @error('dispatcher_challenges')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="dispatcher_comments">Comments</label>
                                        <textarea name="dispatcher_comments" rows="6" class="form-control @error('dispatcher_comments') is-invalid @enderror" required="">{{ $case->dispatcher_comments }}</textarea>
                                        @error('dispatcher_comments')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </section>

                        </div>
                    </div>
                    <!-- /Row -->
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /Container -->

@endsection