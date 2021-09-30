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
                        <h1 class="m-0 text-dark">Facilities</h1>
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
                                @can('facilities_create')

                                    <a class="btn btn-success float-right btn-sm" href="{{route('facilities.create')}}">
                                        <i class="fa fa-plus-circle"></i>
                                        Add Facility
                                    </a>
                                    <a class="btn btn-secondary float-right btn-sm mr-1" href="{{route('facilities.export')}}">
                                        <i class="fas fa-file-export"></i>
                                        Export
                                    </a>
                                @endcan
                                <h3>Facilities List </h3>

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
                                                Name
                                            </th>
                                            <th>
                                                Keph_level
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
                                            <th>
                                                Open Late Night
                                            </th>
                                            <th>
                                                Open on Weekends
                                            </th>
                                            <th>
                                                Open on Public Holiday
                                            </th>

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
                                                <td>{{$facility->open_late_night}}</td>
                                                <td>{{$facility->open_weekends}}</td>
                                                <td>{{$facility->open_public_holiday}}</td>

                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('facilities.show', $facility) }}"><button type="button" class="btn btn-info mr-1"><i class="fas fa-eye " aria-hidden="true"></i></button></a>
                                                        @can('facilities_edit')
                                                        <a href="{{ route('facilities.edit', $facility) }}"><button type="button" class="btn btn-warning mr-1"><i class="fas fa-edit " aria-hidden="true"></i></button></a>
                                                        @endcan
                                                        @can('facilities_delete')
                                                            <form action="{{ route('facilities.destroy', $facility) }}" method="POST" onsubmit = "return confirm('Are you sure?');">
                                                            @csrf
                                                            {{method_field('DELETE')}}
                                                            <button type="submit " class="btn btn-danger  mr-1 "><i class="fas fa-trash " aria-hidden="true"></i></button>
                                                        </form>
                                                        @endcan
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
        </section>

    </div>
@endsection
