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
                        <h1 class="m-0 text-dark">Dispatch Centers</h1>
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
                                @can('dispatch_centers_create')
                                <a class="btn btn-success float-right btn-sm" href="{{route('dispatch_centers.create')}}">
                                    <i class="fa fa-plus-circle"></i>
                                    Add Dispatch Center
                                </a>
                                    <a class="btn btn-secondary float-right btn-sm mr-1" href="{{route('dispatch_centers.export')}}">
                                        <i class="fas fa-file-export"></i>
                                        Export
                                    </a>
                                @endcan
                                <h3>Dispatch Centers List </h3>

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
                                                Emergency Care Center
                                            </th>
                                            <th>
                                                Contact
                                            </th>
                                            <th>
                                                County
                                            </th>
                                            <th>
                                                Sub County
                                            </th>
                                            <th>
                                                Ward
                                            </th>
                                            <th>
                                                Location
                                            </th>
                                            <th>
                                                Open Whole Day
                                            </th>
                                            <th>
                                                Open Late Night
                                            </th>
                                            <th>
                                                Open on Weekends
                                            </th>
                                            <th>
                                                Open on Public Holiday
                                            </th>
                                            @can('dispatch_centers_action_access')
                                            <th>
                                                Action
                                            </th>
                                                @endcan


                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($allData as $key => $dispatch)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{$dispatch->emergency_center->name}}</td>
                                                <td>{{$dispatch->contact}}</td>
                                                <td>{{$dispatch->county}}</td>
                                                <td>{{$dispatch->sub_county}}</td>
                                                <td>{{$dispatch->ward}}</td>
                                                <td>{{$dispatch->location}}</td>
                                                <td>{{$dispatch->open_whole_day}}</td>
                                                <td>{{$dispatch->open_late_night}}</td>
                                                <td>{{$dispatch->open_weekends}}</td>
                                                <td>{{$dispatch->open_public_holiday}}</td>
                                                @can('dispatch_centers_action_access')
                                                <td>
                                                    <div class="btn-group">
                                                        @can('dispatch_centers_edit')
                                                        <a href="{{ route('dispatch_centers.edit', $dispatch->id) }}"><button type="button" class="btn btn-warning mr-1"><i class="fas fa-edit " aria-hidden="true"></i></button></a>
                                                        @endcan
                                                        @can('dispatch_centers_delete')
                                                            <form action="{{ route('dispatch_centers.destroy', $dispatch) }}" method="POST" onsubmit = "return confirm('Are you sure?');">
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
