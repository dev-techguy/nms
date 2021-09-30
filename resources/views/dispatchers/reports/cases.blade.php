@extends('layouts.app')

@section('title', 'Reports - Cases')

@section('orientation', 'hk-horizontal-nav')

@section('navbardirection', 'flex-row')

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
@endpush

@section('content')

<!-- Container -->
<div class="container">
    
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Reports</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cases</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Title -->
    <div class="hk-pg-header">
        <div>
            <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="list"></i></span></span>Cases Report</h4>
        </div>
        <div class="d-flex">
            <a href="{{ route('dispatchers.report.cases.pdf') }}" class="btn btn-primary btn-wth-icon icon-wthot-bg" target="_blank">
                <span class="icon-label"><i class="fa fa-file-pdf-o"></i> </span>
                <span class="btn-text">Download PDF</span>
            </a>
            <a href="{{ route('dispatchers.report.cases.excel') }}" class="btn btn-info btn-wth-icon icon-wthot-bg ml-4" target="_blank">
                <span class="icon-label"><i class="fa fa-file-excel-o"></i> </span>
                <span class="btn-text">Download Excel</span>
            </a>
        </div>
    </div>
    <!-- /Title -->
    
     @include('common.flash-message')
    
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                {{$report->render()}}
            </section>
        </div>
    </div>

</div>
<!-- /Container -->

@endsection
