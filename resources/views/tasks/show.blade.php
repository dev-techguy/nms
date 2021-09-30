@extends('layouts.app')

@section('title', 'Task Show')

@section('orientation', 'hk-vertical-nav')


@push('css')
<!-- Toggles CSS -->
<link href="{{ asset('vendors/jquery-toggles/css/toggles.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('vendors/jquery-toggles/css/themes/toggles-light.css') }}" rel="stylesheet" type="text/css">

@endpush

@push('js')
<!-- Gmap JavaScript -->
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAPS_GEOCODING_API_KEY') }}&libraries=places"></script>
@endpush

@push('js-extended')

@endpush

@section('content')

<!-- Container -->
<div class="container mt-xl-50 mt-sm-30 mt-15">
    <!-- Title -->
    <div class="hk-pg-header align-items-top">
        <div>
            <h2 class="hk-pg-title font-weight-600 mb-5">Task</h2>
        </div>
        <div class="d-flex">
            <a href="#" id="refreshBtn" 
               class="btn btn-primary btn-wth-icon icon-right">
                <span class="btn-text">
                    Last refresh
                    <span id="minutes">00</span>:<span id="seconds">00</span>
                </span>
                <span class="icon-label">
                    <i class="fa fa-refresh"></i> 
                </span>

            </a>
        </div>
    </div>
    <!-- /Title -->

    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap">
                            <table class="table table-bordered table-sm w-100 pb-30">
                                <tr>
                                    <th>Date</th>
                                    <th>{{ $task->created_at }}</th>
                                </tr>
                                <tr>
                                    <th>Driver</th>
                                    <td>{{ $task->driver->name }}</td>
                                </tr>
                                <tr>
                                    <th>Vehicle</th>
                                    <td>{{ $task->vehicle->registration_number }}</td>
                                </tr>
                                <tr>
                                    <th>Emergency Facility</th>
                                    <td>{{ $task->incident->facility->title }}</td>
                                </tr>
                                <tr>
                                    <th>Task</th>
                                    <td>{{ $task->task_name }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if ($task->status == 'pending')
                                        <span class="badge badge-warning">{{ $task->status }}</span>
                                        @elseif ($task->status == 'received')
                                        <span class="badge badge-info">{{ $task->status }}</span>
                                        @elseif ($task->status == 'accepted')
                                        <span class="badge badge-primary">{{ $task->status }}</span>
                                        @elseif ($task->status == 'completed')
                                        <span class="badge badge-success">{{ $task->status }}</span>
                                        @else
                                        <span class="badge badge-secondary">{{ $task->status }}</span>
                                        @endif
                                    </td>
                                </tr>

                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <section class="hk-sec-wrapper">
                <h5 class="hk-sec-title">Track Vehicle</h5>
            </section>
        </div>
        <div class="col-md-4">
            <section class="hk-sec-wrapper">
                <h5 class="hk-sec-title">Activity Log</h5>
                <div class="list-group">
                    @foreach($activities as $item)
                    <a href="#" class="list-group-item flex-column align-items-start">
                        <h5 class="mb-1">{{$item->description}}</h5>
                        <p class="mb-1">by {{$item->causer->name}}</p>
                        <small class="text-muted">on {{ $item->created_at->format('F d, Y h:ia') }}</small>
                    </a>
                    @endforeach
                    
                </div>
            </section>
        </div>
    </div>

</div>
<!-- /Container -->


@endsection
