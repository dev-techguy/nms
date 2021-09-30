@extends('layouts.app')

@section('title', 'Tasks')

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
        <li class="breadcrumb-item"><a href="#">Tasks</a></li>
        <li class="breadcrumb-item active" aria-current="page">List</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

<!-- Container -->
<div class="container">

    <!-- Title -->
    <div class="hk-pg-header">
        <div>
            <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="list"></i></span></span>Tasks</h4>
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
                            <table id="datable_1" class="table table-sm w-100 pb-30">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Driver</th>
                                        <th>Vehicle</th>
                                        <th>Emergency Facility</th>
                                        <th>Task</th>
                                        <th>Status</th>
                                        <th width="15%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tasks as $item)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->driver->name }}</td>
                                        <td>{{ $item->vehicle->registration_number }}</td>
                                        <td>{{ $item->incident->facility->title }}</td>
                                        <td>{{ $item->task_name }}</td>
                                        <td>
                                            @if ($item->status == 'pending')
                                            <span class="badge badge-warning">{{ $item->status }}</span>
                                            @elseif ($item->status == 'received')
                                            <span class="badge badge-info">{{ $item->status }}</span>
                                            @elseif ($item->status == 'accepted')
                                            <span class="badge badge-primary">{{ $item->status }}</span>
                                            @elseif ($item->status == 'completed')
                                            <span class="badge badge-success">{{ $item->status }}</span>
                                            @else
                                            <span class="badge badge-secondary">{{ $item->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('tasks.show', $item) }}" class="btn btn-info btn-xs mr-25" data-toggle="tooltip" data-original-title="View"> <i class="icon-magnifier"></i> View More</a>
                                            @if ($item->status == 'pending'
                                                || $item->status == 'received'
                                                || $item->status == 'accepted')
                                                <form class="d-inline" method="POST" action="{{route('tasks.destroy', $item)}}" onclick="return confirm('Are you sure you want to cancel this task?');">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-xs mt-10"><i class="fa fa-trash"></i> Cancel</button>
                                                </form>
                                            
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
