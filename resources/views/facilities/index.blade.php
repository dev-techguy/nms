@extends('layouts.app')

@section('title', 'Facilities')

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
@endpush

@section('content')
<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Facilities</a></li>
        <li class="breadcrumb-item active" aria-current="page">List</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

<!-- Container -->
<div class="container">

    <!-- Title -->
    <div class="hk-pg-header">
        <div>
            <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="list"></i></span></span>Facilities</h4>
        </div>
        <div class="d-flex">
            <a href="{{ route('facilities.create') }}" class="btn btn-primary btn-wth-icon icon-wthot-bg"><span class="icon-label"><i class="fa fa-plus"></i> </span><span class="btn-text">Add Facility</span></a>
        </div>
    </div>
    <!-- /Title -->

    @include('common.flash-message')

    <!-- Row -->
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap">
                            <table id="datable_1" class="table table-sm w-100 pb-30 table-responsive">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>
                                            Level
                                        </th>
                                        <th>
                                            County
                                        </th>
                                        <th>
                                            Constituency
                                        </th>
                                        <th>
                                            Ward
                                        </th>
                                        <th>
                                            Open Whole Day
                                        </th>
                                        <!--<th>
                                            Open Late Night
                                        </th>
                                        <th>
                                            Open on Weekends
                                        </th>
                                        <th>
                                            Open on Public Holiday
                                        </th>-->

                                        <th>
                                            Action
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($allData as $key => $facility)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$facility->title}}</td>
                                        <td>{{$facility->keph_level}}</td>
                                        <td>{{$facility->county}}</td>
                                        <td>{{$facility->constituency}}</td>
                                        <td>{{$facility->ward}}</td>
                                        <td>{{$facility->open_whole_day}}</td>
                                        <!--<td>{{$facility->open_late_night}}</td>
                                        <td>{{$facility->open_weekends}}</td>
                                        <td>{{$facility->open_public_holiday}}</td>-->

                                        <td>
                                            <div class="btn-group">
                                            <a href="{{ route('facilities.edit', $facility) }}" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i> Edit</a>
                                            <form class="d-inline" method="POST" action="{{route('facilities.destroy', $facility)}}" onclick="return confirm('Are you sure you want to delete this facility?');">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</button>
                                            </form>
                                            </div>
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
