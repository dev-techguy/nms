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
                                <a class="btn btn-success float-right btn-sm" href="{{route('facilities.index')}}">
                                    <i class="fa fa-list-ol"></i>
                                    Facilities list
                                </a>
                                <h3>Facility Details </h3>

                            </div>
                            <div class="card-body table-responsive p-0">
                                <div class="table">
                                    <table class=" table table-bordered table-striped table-hover">
                                        <tbody>

                                                <tr>
                                                    <th>
                                                        Id
                                                    </th>
                                                    <td>
                                                        {{ $showData->id }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>
                                                        Name
                                                    </th>
                                                    <td>
                                                        {{ $showData->title }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Keph Level
                                                    </th>
                                                    <td>
                                                        {{ $showData->keph_level }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Facility Type
                                                    </th>
                                                    <td>
                                                        {{ $showData->type }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Facility Category
                                                    </th>
                                                    <td>
                                                        {{ $showData->category }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Owner
                                                    </th>
                                                    <td>
                                                        {{ $showData->ownership }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Regulatory body
                                                    </th>
                                                    <td>
                                                        {{ $showData->regulatory_body }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Contact
                                                    </th>
                                                    <td>
                                                        {{ $showData->contact }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Primary Response
                                                    </th>
                                                    <td>
                                                        @if ( $showData->primary_response == 'No')
                                                            <span class="badge badge-danger">Unavailable</span>
                                                        @else
                                                            <span class="badge badge-success">Available</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Inter Facility Transfer
                                                    </th>
                                                    <td>
                                                        @if ( $showData->inter_facility_transfer == 'No' )
                                                            <span class="badge badge-danger">Unavailable</span>
                                                        @else
                                                            <span class="badge badge-success">Available</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Emergency Department
                                                    </th>
                                                    <td>
                                                        @if ( $showData->emergency_dpt == 'No' )
                                                            <span class="badge badge-danger">Unavailable</span>
                                                        @else
                                                            <span class="badge badge-success">Available</span>
                                                        @endif

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        EMS for trauma
                                                    </th>
                                                    <td>
                                                        @if ( $showData->trauma_care == 'No' )
                                                            <span class="badge badge-danger">Unavailable</span>
                                                        @else
                                                            <span class="badge badge-success">Available</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        EMS for stroke
                                                    </th>
                                                    <td>
                                                        @if ( $showData->stroke_care == 'No' )
                                                            <span class="badge badge-danger">Unavailable</span>
                                                        @else
                                                            <span class="badge badge-success">Available</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        EMS for heart attack
                                                    </th>
                                                    <td>
                                                        @if ( $showData->heart_attacks == 'No' )
                                                            <span class="badge badge-danger">Unavailable</span>
                                                        @else
                                                            <span class="badge badge-success">Available</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Number of theater
                                                    </th>
                                                    <td>
                                                        {{ $showData->theater_stats }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Number of X Ray machines
                                                    </th>
                                                    <td>
                                                        {{ $showData->x_ray_stats }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Number of CT scan machines
                                                    </th>
                                                    <td>
                                                        {{ $showData->CT_stats }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Number of ultra sound machines
                                                    </th>
                                                    <td>
                                                        {{ $showData->ultra_sound_stats }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Neurosurgeons
                                                    </th>
                                                    <td>

                                                        @if ( $showData->neurosurgeons == 'No' )
                                                            <span class="badge badge-danger">Unavailable</span>
                                                        @else
                                                            <span class="badge badge-success">Available</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Orthopedics surgeons
                                                    </th>
                                                    <td>

                                                        @if ( $showData->orthopedics_surgeons == 'No' )
                                                            <span class="badge badge-danger">Unavailable</span>
                                                        @else
                                                            <span class="badge badge-success">Available</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Open Whole Day
                                                    </th>
                                                    <td>
                                                        {{ $showData->open_whole_day }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Open late night
                                                    </th>
                                                    <td>
                                                        {{ $showData->open_late_night }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Open on weekends
                                                    </th>
                                                    <td>
                                                        {{ $showData->open_weekends }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Open on public holiday
                                                    </th>
                                                    <td>
                                                        {{ $showData->open_public_holiday }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Status
                                                    </th>
                                                    <td>

                                                        @if ( $showData->status == 'Nonoperational' )
                                                            <span class="badge badge-danger">Nonoperational</span>
                                                        @else
                                                            <span class="badge badge-success">Operational</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Approved
                                                    </th>
                                                    <td>
                                                        @if ( $showData->approved  == 'No' )
                                                            <span class="badge badge-danger">Disapproved</span>
                                                        @else
                                                            <span class="badge badge-success">Approved</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        County
                                                    </th>
                                                    <td>
                                                        {{ $showData->county }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Constituency
                                                    </th>
                                                    <td>
                                                        {{ $showData->constituency }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                       Ward
                                                    </th>
                                                    <td>
                                                        {{ $showData->ward }}
                                                    </td>
                                                </tr>


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
