@extends('layouts.app')

@section('title', 'Reports')

@section('orientation', 'hk-horizontal-nav')

@section('navbardirection', 'flex-row')

@push('css')
    <!-- Data Table CSS -->
    <link href="{{ asset('vendors/datatables.net-dt/css/jquery.dataTables.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('vendors/datatables.net-responsive-dt/css/responsive.dataTables.min.css') }}" rel="stylesheet"
          type="text/css"/>

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
                <li class="breadcrumb-item active" aria-current="page">List</li>
            </ol>
        </nav>
        <!-- /Breadcrumb -->

        <!-- Title -->
        <div class="hk-pg-header">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i
                                data-feather="list"></i></span></span>Reports</h4>
            </div>
        </div>
        <!-- /Title -->

        @include('common.flash-message')

        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm shadow-hover-lg">
                    <div class="card-body">
                        <h5 class="card-title">All Cases</h5>
                        <form action="{{ route('generate.report') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="from_date">From Date</label>
                                <input type="date"
                                       class="form-control @error('from_date') is-invalid @enderror" name="from_date"
                                       id="from_date" required placeholder="Select Date">
                                @error('from_date')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="to_date">To Date</label>
                                <input type="date"
                                       class="form-control @error('to_date') is-invalid @enderror" name="to_date"
                                       id="to_date" required placeholder="Select Date">
                                @error('to_date')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary pull-right">Submit</button>
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive">
                        @if(isset($report))
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Report Name</th>
                                    <th>From Date</th>
                                    <th>To Date</th>
                                    <th>Action</th>
                                    <th>Updated</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($count = 1)
                                <tr>
                                    <td>{{ $count }}</td>
                                    <td>{{ $report->path_name }}</td>
                                    <td>{{ date('F d, Y h:i a', strtotime($report->from_date)) }}</td>
                                    <td>{{ date('F d, Y h:i a', strtotime($report->to_date)) }}</td>
                                    <td>
                                        @if($report->is_ready)
                                            <a href="{{ asset('storage/' . $report->path_name) }}"
                                               class="btn btn-sm btn-outline-success"><span
                                                    class="fa fa-download"></span></a>
                                        @else
                                            <a href="{{ route('watchers.report') }}"
                                               class="btn btn-sm btn-outline-danger">
                                                Refresh
                                            </a>
                                        @endif
                                    </td>
                                    <td>{{ \App\Http\Controllers\SystemController::elapsedTime($report->updated_at) }}</td>
                                </tr>
                                </tbody>
                            </table>
                        @else
                            <hr>
                            <p class="text-center text-danger text-uppercase"><strong>Generate
                                    a
                                    report to get the download
                                    view</strong></p>
                            <hr>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Container -->

@endsection
