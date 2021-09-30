@extends('layouts.admin')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Ambulances</h1>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <section class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <a class="btn btn-success float-right btn-sm" href="{{route('ambulances.index')}}">
                                    <i class="fa fa-list-ol"></i>
                                    Ambulances List
                                </a>
                                <h3>Edit Ambulance </h3>

                            </div>
                            <div class="card-body">
                                <form action="{{route("ambulances.update" , $editData->id)}}" method="POST" enctype="multipart/form-data" >
                                    @csrf
                                    @method('PUT')
                                    <div class="form-row">
                                        <div class="form-group col-md-4" {{ $errors->has('dispatch_center_id') ? 'has-error' : '' }}>
                                            <label for="dispatch_center_id">Dispatch Center (Location)</label>
                                            <select class="form-control" id="dispatch_center_id" name="dispatch_center_id" required>
                                                <option value="">-- Select Emergency Care Center --</option>
                                                @foreach($data as $key => $dispatch)
                                                    <option value="{{$dispatch->id}}" {{($editData->dispatch_center_id == $dispatch->id) ? "selected" : ''}}>{{$dispatch->emergency_center->name}} ({{$dispatch->latitude}} , {{$dispatch->longitude}})</option>
                                                @endforeach

                                            </select>
                                            @if($errors->has('dispatch_center_id'))
                                                <p class="help-block">
                                                    {{ $errors->first('dispatch_center_id') }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-4" {{ $errors->has('basic_stats') ? 'has-error' : '' }}>
                                            <label for="basic_stats">No of Basic Ambulances</label>
                                            <input id="basic_stats" name="basic_stats" type="text" class="form-control" value="{{$editData->basic_stats}}" required>
                                            @if($errors->has('basic_stats'))
                                                <p class="help-block">
                                                    {{ $errors->first('basic_stats') }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-4" {{ $errors->has('advanced_stats') ? 'has-error' : '' }}>
                                            <label for="advanced_stats">No of Advance Life Support Ambulances</label>
                                            <input id="advanced_stats" name="advanced_stats" type="text" class="form-control" value="{{$editData->advanced_stats}}" required>
                                            @if($errors->has('advanced_stats'))
                                                <p class="help-block">
                                                    {{ $errors->first('advanced_stats') }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-4" {{ $errors->has('gps_enabled') ? 'has-error' : '' }}>
                                            <label for="gps_enabled">GPS</label>
                                            <select class="form-control" id="gps_enabled" name="gps_enabled" required>
                                                <option value="">-- Select --</option>
                                                <option value="1" {{ $editData->gps_enabled == 1 ? 'selected' : '' }}>Enabled</option>
                                                <option value="0" {{ $editData->gps_enabled == 0 ? 'selected' : '' }}>Disabled</option>
                                            </select>
                                            @if($errors->has('gps_enabled'))
                                                <p class="help-block">
                                                    {{ $errors->first('gps_enabled') }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-4" {{ $errors->has('EMTs_stats') ? 'has-error' : '' }}>
                                            <label for="EMTs_stats">No of EMTs</label>
                                            <input id="EMTs_stats" name="EMTs_stats" type="text" class="form-control" value="{{$editData->EMTs_stats}}" required>
                                            @if($errors->has('EMTs_stats'))
                                                <p class="help-block">
                                                    {{ $errors->first('EMTs_stats') }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-4" {{ $errors->has('driver_stats') ? 'has-error' : '' }}>
                                            <label for="driver_stats">No of drivers</label>
                                            <input id="driver_stats" name="driver_stats" type="text" class="form-control" value="{{$editData->driver_stats}}" required>
                                            @if($errors->has('driver_stats'))
                                                <p class="help-block">
                                                    {{ $errors->first('driver_stats') }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-4" {{ $errors->has('shift_stats') ? 'has-error' : '' }}>
                                            <label for="shift_stats">No of shifts</label>
                                            <input id="shift_stats" name="shift_stats" type="text" class="form-control" value="{{$editData->shift_stats}}" required>
                                            @if($errors->has('shift_stats'))
                                                <p class="help-block">
                                                    {{ $errors->first('shift_stats') }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-4" {{ $errors->has('staff_per_shift_stats') ? 'has-error' : '' }}>
                                            <label for="staff_per_shift_stats">No of staff per shift</label>
                                            <input id="staff_per_shift_stats" name="staff_per_shift_stats" type="text" class="form-control" value="{{$editData->staff_per_shift_stats}}" required>
                                            @if($errors->has('staff_per_shift_stats'))
                                                <p class="help-block">
                                                    {{ $errors->first('staff_per_shift_stats') }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-1" style="padding-top: 30px;">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>

            </div>
        </section>

    </div>
@endsection
