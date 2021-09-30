@extends('layouts.app')

@section('title', 'Dashboard')

@section('orientation', 'hk-horizontal-nav')

@section('navbardirection', 'flex-row')

@push('css')
    <!-- vector map CSS -->
    <link href="{{ asset('vendors/vectormap/jquery-jvectormap-2.0.3.css') }}" rel="stylesheet" type="text/css"/>

    <!-- Toggles CSS -->
    <link href="{{ asset('vendors/jquery-toggles/css/toggles.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendors/jquery-toggles/css/themes/toggles-light.css') }}" rel="stylesheet" type="text/css">

    <!-- Toastr CSS -->
    <link href="{{ asset('vendors/jquery-toast-plugin/dist/jquery.toast.min.css') }}" rel="stylesheet" type="text/css">
@endpush

@push('js')
    <!-- Counter Animation JavaScript -->
    <script src="{{ asset('vendors/waypoints/lib/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('vendors/jquery.counterup/jquery.counterup.min.js') }}"></script>

    <!-- Morris Charts JavaScript -->
    <script src="{{ asset('vendors/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('vendors/morris.js/morris.min.js') }}"></script>

    <!-- EChartJS JavaScript -->
    <script src="{{ asset('vendors/echarts/dist/echarts-en.min.js') }}"></script>

    <!-- Sparkline JavaScript -->
    <script src="{{ asset('vendors/jquery.sparkline/dist/jquery.sparkline.min.js') }}"></script>

    <!-- Vector Maps JavaScript -->
    <script src="{{ asset('vendors/vectormap/jquery-jvectormap-2.0.3.min.js') }}"></script>
    <script src="{{ asset('vendors/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('js/vectormap-data.js') }}"></script>

    <!-- Owl JavaScript -->
    <script src="{{ asset('vendors/owl.carousel/dist/owl.carousel.min.js') }}"></script>

    <!-- Toastr JS -->
    <script src="{{ asset('vendors/jquery-toast-plugin/dist/jquery.toast.min.js') }}"></script>
@endpush

@push('js-extended')
    <script src="{{ asset('js/dashboard-data.js') }}"></script>
@endpush

@section('content')

    <!-- Container -->
    <div class="container mt-xl-50 mt-sm-30 mt-15">
        <!-- Title -->
        <div class="hk-pg-header align-items-top">
            <div>
                <h2 class="hk-pg-title font-weight-600 mb-10">Watchers Dashboard</h2>
            </div>
            <div class="d-flex mb-0 flex-wrap">
                <div class="btn-group btn-group-sm btn-group-rounded mb-15 mr-15" role="group">
                    <a href="{{ route('incidents.index') }}" class="btn btn-outline-primary">My Cases</a>
                    <a href="{{ route('profile.show') }}" class="btn btn-outline-primary">My Profile</a>
                </div>
                <a href="{{ route('incidents.create') }}"
                   class="btn btn-sm btn-outline-primary btn-rounded btn-wth-icon icon-wthot-bg mb-15">
                    <span class="icon-label"><span class="feather-icon"><i data-feather="plus"></i></span> </span>
                    <span class="btn-text">New Case</span>
                </a>
            </div>

        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <div class="hk-row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="card card-sm">
                            <div class="card-body">
                                <span class="d-block font-11 font-weight-500 text-dark text-uppercase mb-10">New Cases Last 24 hours</span>
                                <div class="d-flex align-items-center justify-content-between position-relative">
                                    <div>
                                        <span class="d-block display-5 font-weight-400 text-dark">{{$stats['month_new']}} New</span>
                                    </div>
                                    <div>
                                        <!--<span class="text-success font-12 font-weight-600">+0%</span>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card card-sm">
                            <div class="card-body">
                                <span class="d-block font-11 font-weight-500 text-dark text-uppercase mb-10">Submitted Cases</span>
                                <div class="d-flex align-items-center justify-content-between position-relative">
                                    <div>
                                    <span class="d-block">
                                        <span class="display-5 font-weight-400 text-dark"><span
                                                class="counter-anim">{{$stats['submitted']}}</span></span>
                                    </span>
                                    </div>
                                    <div>
                                        <!--<span class="text-success font-12 font-weight-600">+0%</span>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card card-sm">
                            <div class="card-body">
                                <span
                                    class="d-block font-11 font-weight-500 text-dark text-uppercase mb-10">Draft Cases</span>
                                <div class="d-flex align-items-end justify-content-between">
                                    <div>
                                    <span class="d-block">
                                        <span class="display-5 font-weight-400 text-dark">{{$stats['draft']}}</span>
                                    </span>
                                    </div>
                                    <div>
                                        <!--<span class="text-success font-12 font-weight-600">+0%</span>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card card-sm">
                            <div class="card-body">
                                <span
                                    class="d-block font-11 font-weight-500 text-dark text-uppercase mb-10">Total Cases</span>
                                <div class="d-flex align-items-end justify-content-between">
                                    <div>
                                    <span class="d-block">
                                        <span class="display-5 font-weight-400 text-dark">{{$stats['total']}}</span>
                                    </span>
                                    </div>
                                    <div>
                                        <!--<span class="text-danger font-12 font-weight-600">+0%</span>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hk-row">
                    <div class="col-sm-12">
                        <div class="card-group hk-dash-type-2">
                            <div class="card card-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-5">
                                        <div>
                                            <span class="d-block font-15 text-dark font-weight-500">Last 24 Hours</span>
                                        </div>
                                        <div>
                                            <!--<span class="text-success font-14 font-weight-500">+0%</span>-->
                                        </div>
                                    </div>
                                    <div>
                                        <span
                                            class="d-block display-4 text-dark mb-5">{{$stats['month_resolved']}}</span>
                                        <small class="d-block">Resolved Cases</small>
                                    </div>
                                </div>
                            </div>

                            <div class="card card-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-5">
                                        <div>
                                            <span class="d-block font-15 text-dark font-weight-500">Last 24 Hours</span>
                                        </div>
                                        <div>
                                            <!--<span class="text-success font-14 font-weight-500">+0%</span>-->
                                        </div>
                                    </div>
                                    <div>
                                        <span class="d-block display-4 text-dark mb-5"><span
                                                class="counter-anim">{{$stats['month_unresolved']}}</span></span>
                                        <small class="d-block">Unresolved Cases</small>
                                    </div>
                                </div>
                            </div>

                            <div class="card card-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-5">
                                        <div>
                                            <span class="d-block font-15 text-dark font-weight-500">Total</span>
                                        </div>
                                        <div>
                                            <!--<span class="text-warning font-14 font-weight-500">0%</span>-->
                                        </div>
                                    </div>
                                    <div>
                                        <span
                                            class="d-block display-4 text-dark mb-5">{{$stats['total_resolved']}}</span>
                                        <small class="d-block">Resolved Cases</small>
                                    </div>
                                </div>
                            </div>

                            <div class="card card-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-5">
                                        <div>
                                            <span class="d-block font-15 text-dark font-weight-500">Total</span>
                                        </div>
                                        <div>
                                            <!--<span class="text-danger font-14 font-weight-500">0%</span>-->
                                        </div>
                                    </div>
                                    <div>
                                        <span
                                            class="d-block display-4 text-dark mb-5">{{$stats['total_unresolved']}}</span>
                                        <small class="d-block">Unresolved Cases</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between mt-40 mb-20">
                    <h4>Graph Analysis</h4>
                    <a href="{{ route('incidents.index') }}" class="btn btn-sm btn-link">view Cases</a>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body pa-0">
                                <div id="chart" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body pa-0">
                                <div id="pie_chart" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Row -->
    </div>
    <!-- /Container -->
    <!-- Charting library -->
    <script src="https://unpkg.com/echarts/dist/echarts.min.js"></script>
    <!-- Chartisan -->
    <script src="https://unpkg.com/@chartisan/echarts/dist/chartisan_echarts.js"></script>
    <!-- Your application script -->
    <script>
        const chart = new Chartisan({
            el: '#chart',
            url: "@chart('watcher_chart')",
            loader: {
                color: '#2c3187',
                size: [30, 30],
                type: 'bar',
                textColor: '#000000',
                text: 'Loading some chart data...',
            },
            hooks: new ChartisanHooks()
                .legend()
                .colors(['#2c3187', '#f51b29'])
                .datasets(['bar', 'line'])
                .tooltip(),
        });
        const pie_chart = new Chartisan({
            el: '#pie_chart',
            url: "@chart('watcher_pie_chart')",
            loader: {
                color: '#2c3187',
                size: [30, 30],
                type: 'bar',
                textColor: '#000000',
                text: 'Loading some chart data...',
            },
            hooks: new ChartisanHooks()
                .legend()
                .datasets(['pie'])
                .tooltip(),
        });
    </script>
@endsection
