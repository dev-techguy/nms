@extends('layouts.admin')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <table width="100%">
                    <tr>
                        <td width="34%"><img  src="{{ asset('AdminLTE/dist/img/ministry of health.png')}}"  style="width: 200px; height: 140px;">  </td>
                        <td width=""><img  src="{{ asset('AdminLTE/dist/img/NAMSIP.png')}}"  style="width: 200px; height: 140px;"> </td>
                        <td width="20"><img  src="{{ asset('AdminLTE/dist/img/malteser.png')}}" class="float-right"  style="width: 400px; height: 140px;" ></td>
                    </tr>
                </table>
                <hr>
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
                                @can('ambulances_create')
                                <a class="btn btn-success float-right btn-sm" href="{{route('ambulances.create')}}">
                                    <i class="fa fa-plus-circle"></i>
                                    Add Ambulance
                                </a>
                                    <a class="btn btn-secondary float-right btn-sm mr-1" href="{{route('ambulances.export')}}">
                                        <i class="fas fa-file-export"></i>
                                        Export
                                    </a>
                                @endcan
                                <h3>Ambulances List </h3>

                            </div>
                            <div class="card-body table-responsive p-0">
                                <div class="table">
                                    <table class=" table table-bordered table-striped table-hover" id="myTable">
                                        <thead>
                                        <tr>
                                            <th>
                                                #
                                            </th>
                                            <th>
                                                Dispatch Center
                                            </th>
                                            <th>
                                                No of Basic
                                            </th>
                                            <th>
                                                No of Advance Life Support
                                            </th>
                                            <th>
                                                No of EMT
                                            </th>
                                            <th>
                                                No of Drivers
                                            </th>
                                            <th>
                                                No of shift
                                            </th>
                                            <th>
                                                No of staff per shift
                                            </th>
                                            <th>
                                                GPS
                                            </th>
                                            @can('ambulances_action_access')
                                            <th>
                                                Action
                                            </th>
                                            @endcan



                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($allData as $key => $ambulances)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{$ambulances->dispatch_center->emergency_center->name}} ({{$ambulances->dispatch_center->location}})</td>
                                                <td>{{$ambulances->basic_stats}}</td>
                                                <td>{{$ambulances->advanced_stats}}</td>
                                                <td>{{$ambulances->EMTs_stats}}</td>
                                                <td>{{$ambulances->driver_stats}}</td>
                                                <td>{{$ambulances->shift_stats}}</td>
                                                <td>{{$ambulances->staff_per_shift_stats}}</td>
                                                <td>
                                                    @if ( $ambulances->gps_enabled == 0 )
                                                        <span class="badge badge-danger">Disabled</span>
                                                    @else
                                                        <span class="badge badge-success">Enabled</span>
                                                    @endif
                                                </td>
                                                @can('ambulances_action_access')
                                                <td>
                                                    <div class="btn-group">
                                                        @can('ambulances_edit')
                                                        <a href="{{ route('ambulances.edit', $ambulances->id) }}"><button type="button" class="btn btn-warning mr-1"><i class="fas fa-edit " aria-hidden="true"></i></button></a>
                                                        @endcan
                                                        @can('ambulances_delete')
                                                            <form action="{{ route('ambulances.destroy', $ambulances) }}" method="POST" onsubmit = "return confirm('Are you sure?');">
                                                            @csrf
                                                            {{method_field('DELETE')}}
                                                            <button type="submit " class="btn btn-danger  mr-1 "><i class="fas fa-trash " aria-hidden="true"></i></button>
                                                        </form>
                                                            @endcan
                                                    </div>
                                                </td>
                                                @endcan
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
        </section>

    </div>
@endsection
