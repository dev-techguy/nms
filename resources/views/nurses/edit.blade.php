@extends('layouts.app')

@section('title', 'Edit Nurse')

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
        <li class="breadcrumb-item"><a href="#">Paramedics</a></li>
        <li class="breadcrumb-item"><a href="{{ route('nurses.index') }}">Paramedics</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

<!-- Container -->
<div class="container">
    <!-- Title -->
    <div class="hk-pg-header">
        <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="edit-2"></i></span></span>Edit Nurse</h4>
    </div>
    <!-- /Title -->

    @include('common.flash-message')

    <!-- Row -->
    <div class="row">
        <div class="col-md-12">
            <section class="hk-sec-wrapper">
                <h5 class="hk-sec-title">Edit Paramedic Details</h5>
                <form method="POST" action="{{route('nurses.update', $user->id)}}" role="form">
                    @method('PUT')
                    @csrf

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ $user->name }}" required=""  placeholder="Enter name">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ $user->email }}" required=""  placeholder="Enter email">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone" value="{{ $user->phone }}" required=""  placeholder="Enter phone">
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="id_number">ID Number</label>
                        <input type="text" name="id_number" class="form-control @error('id_number') is-invalid @enderror" id="phone" value="{{ $user->id_number }}" required=""  placeholder="Enter ID Number">
                        @error('id_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Enter Password">
                        <small id="passwordHelp" class="form-text text-muted">Leave it blank if you are not changing password</small>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" placeholder="Enter Password Confirmation">
                        <small id="passwordHelp" class="form-text text-muted">Leave it blank if you are not changing password</small>
                        @error('password_confirmation')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
