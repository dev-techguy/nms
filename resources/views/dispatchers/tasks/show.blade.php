@extends('layouts.app')

@section('title', 'Task')

@section('orientation', 'hk-horizontal-nav')

@section('navbardirection', 'flex-row')


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
<div class="container">
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Cases</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cases.index') }}">Cases</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tasks</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    @include('dispatchers.single.casetitle')

    @include('common.flash-message')

    <div class="row">
        <div class="col-xl-12 pa-0">

            @include('dispatchers.single.casenav', ['active' => 'tasks'])

            <div class="tab-content mt-sm-40 mt-20">

                <div class="tab-pane fade show active" role="tabpanel">
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
                                                    <th>EMT</th>
                                                    <td>{{ $task->emt->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Paramedic</th>
                                                    <td>{{ $task->nurse->name }}</td>
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
                                                <tr>
                                                    <th>Accepted on</th>
                                                    <td>{{ $task->accepted_on }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Completed on</th>
                                                    <td>{{ $task->completed_on }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Pick Time</th>
                                                    <td>{{ $task->pick_time }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Facility Arrival Time</th>
                                                    <td>{{ $task->facility_arrival_time }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Challenges</th>
                                                    <td>{{ $task->challenges }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Comments</th>
                                                    <td>{{ $task->comments }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Guest Paramedic</th>
                                                    <td>{{ $task->guest_nurse_name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Guest Phone</th>
                                                    <td>{{ $task->guest_nurse_phone }}</td>
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
            </div>
        </div>
    </div>

</div>
<!-- /Container -->


@endsection
