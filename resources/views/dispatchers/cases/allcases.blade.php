@extends('layouts.app')

@section('title', 'All Cases')

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
            <li class="breadcrumb-item"><a href="#">Cases</a></li>
            <li class="breadcrumb-item active" aria-current="page">List</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Title -->
    <div class="hk-pg-header">
        <div>
            <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="list"></i></span></span>All Cases</h4>
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
                                        <th>Case ID</th>
                                        <th>Date Received</th>
                                        <th>Mode</th>
                                        <th>Location</th>
                                        <!--<th>Alert Nature</th>
                                        <th>Chief Complaint</th>-->
                                        <th>Watcher</th>
                                        <th>Dispatcher</th>
                                        <th>Status</th>
                                        <th>TAT</th>
                                        <th width="18%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $item)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{ $item->case_number }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->alert_mode }}</td>
                                        <td>{{ $item->location }}</td>
                                        <!--<td>{{ $item->alert_nature }}</td>
                                        <td>{{ $item->chief_complaint }}</td>-->
                                        <td>{{ $item->watcher->name }}</td>
                                        <td>{{ $item->dispatcher->name }}</td>
                                        <td>
                                            @if ($item->status == 'submitted')
                                            <span class="badge badge-warning">Pending</span>
                                            @elseif ($item->status == 'dispatch_handling')
                                            <span class="badge badge-info">{{ $item->status }}</span>
                                            @elseif ($item->status == 'dispatched')
                                            <span class="badge badge-primary">{{ $item->status }}</span>
                                            @elseif ($item->status == 'resolved')
                                            <span class="badge badge-success">{{ $item->status }}</span>
                                            @else
                                            <span class="badge badge-secondary">{{ $item->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->status == 'resolved')
                                                {{ $item->created_at->diffForHumans($item->updated_at, true) }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('cases.show', $item) }}" class="btn btn-info btn-xs mb-10" data-toggle="tooltip" data-original-title="View"> <i class="icon-magnifier"></i> View More</a>
                                            
                                            @if ($item->status == 'submitted')
                                            <form class="d-inline" method="POST" action="{{route('cases.manage', $item)}}" onclick="return confirm('Are you sure you want to handle this case?');">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-xs mt-6"><i class="fa fa-cog"></i> Manage Case</button>
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
