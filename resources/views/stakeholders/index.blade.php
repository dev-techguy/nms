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
                        <h1 class="m-0 text-dark">Stakeholders</h1>
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
                                @can('stakeholders_create')
                                <a class="btn btn-success float-right btn-sm" href="{{route('stakeholders.create')}}">
                                    <i class="fa fa-plus-circle"></i>
                                    Add Stakeholder
                                </a>
                                    <a class="btn btn-secondary float-right btn-sm mr-1" href="{{route('stakeholders.export')}}">
                                        <i class="fas fa-file-export"></i>
                                        Export
                                    </a>
                                @endcan
                                <h3>Stakeholders List </h3>

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
                                                Email
                                            </th>
                                            <th>
                                                Contact
                                            </th>
                                            <th>
                                                Institution
                                            </th>
                                            @can('stakeholders_action_access')
                                            <th>
                                                Action
                                            </th>
                                            @endcan


                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($allData as $key => $stakeholder)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{$stakeholder->name}}</td>
                                                <td>{{$stakeholder->email}}</td>
                                                <td>{{$stakeholder->contact}}</td>
                                                <td>{{$stakeholder->institution}}</td>
                                                @can('stakeholders_action_access')
                                                <td>
                                                    <div class="btn-group">
                                                        @can('stakeholders_edit')
                                                        <a href="{{ route('stakeholders.edit', $stakeholder->id) }}"><button type="button" class="btn btn-warning mr-1"><i class="fas fa-edit " aria-hidden="true"></i></button></a>
                                                        @endcan
                                                            @can('stakeholders_delete')
                                                            <form action="{{ route('stakeholders.destroy', $stakeholder) }}" method="POST" onsubmit = "return confirm('Are you sure?');">
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
