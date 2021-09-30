<!-- Main Nav -->
<nav class="hk-nav hk-nav-dark">
    <a href="javascript:void(0);" id="hk_nav_close" class="hk-nav-close"><span class="feather-icon"><i data-feather="x"></i></span></a>
    <div class="nicescroll-bar">
        <div class="navbar-nav-wrap">
            <ul class="navbar-nav @yield('navbardirection', 'flex-column')">
                <li class="nav-item {{Request::routeIs('dashboard')?'active':''}}">
                    <a class="nav-link" href="{{ route('dashboard') }}" >
                        <span class="feather-icon"><i data-feather="bar-chart-2"></i></span>
                        <span class="nav-link-text">Dashboard</span>
                    </a>
                </li>
                @can('Dispatch Ambulances')
                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#dispatch_drp">
                        <span class="feather-icon"><i data-feather="truck"></i></span>
                        <span class="nav-link-text">Dispatch</span>
                    </a>
                    <ul id="dispatch_drp" class="nav flex-column collapse collapse-level-1
                        {{Request::routeIs('dispatch.*')?'collapse show':''}}">
                        <li class="nav-item">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('dispatch.index') }}">Map View</a>
                                </li>
                                <!--<li class="nav-item">
                                    <a class="nav-link" href="{{ route('dispatch.list') }}">List View</a>
                                </li>-->

                            </ul>
                        </li>
                    </ul>
                </li>
                @endcan

                <li class="nav-item {{Request::is('tasks*')?'active':''}}">
                    <a class="nav-link" href="{{ route('tasks.index') }}" >
                        <span class="feather-icon"><i data-feather="activity"></i></span>
                        <span class="nav-link-text">Tasks</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#drivers_drp">
                        <span class="feather-icon"><i data-feather="users"></i></span>
                        <span class="nav-link-text">Operators</span>
                    </a>
                    <ul id="drivers_drp" class="nav flex-column collapse collapse-level-1
                        {{Request::is('drivers*')?'collapse show':''}}">
                        <li class="nav-item">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('drivers.index') }}">All Operators</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('drivers.create') }}">New Driver</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#emts_drp">
                        <span class="feather-icon"><i data-feather="users"></i></span>
                        <span class="nav-link-text">EMTs</span>
                    </a>
                    <ul id="emts_drp" class="nav flex-column collapse collapse-level-1
                        {{Request::is('emts*')?'collapse show':''}}">
                        <li class="nav-item">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('emts.index') }}">All EMTs</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('emts.create') }}">New EMT</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#nurses_drp">
                        <span class="feather-icon"><i data-feather="users"></i></span>
                        <span class="nav-link-text">Paramedics</span>
                    </a>
                    <ul id="nurses_drp" class="nav flex-column collapse collapse-level-1
                        {{Request::is('nurses*')?'collapse show':''}}">
                        <li class="nav-item">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('nurses.index') }}">All Paramedics</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('nurses.create') }}">New Paramedic</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <li class="nav-item {{Request::is('vehicles*')?'active':''}}">
                    <a class="nav-link" href="{{ route('vehicles.index') }}" >
                        <span class="feather-icon"><i data-feather="truck"></i></span>
                        <span class="nav-link-text">Ambulances</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#facilities">
                        <span class="feather-icon"><i data-feather="home"></i></span>
                        <span class="nav-link-text">Facilities</span>
                    </a>
                    <ul id="facilities" class="nav flex-column collapse collapse-level-1
                        {{Request::is('facilities*')?'collapse show':''}}">
                        <li class="nav-item">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('facilities.index') }}">All Facilities</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('facilities.create') }}">New Facility</a>
                                </li>

                            </ul>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#emergency-centers">
                        <span class="feather-icon"><i data-feather="list"></i></span>
                        <span class="nav-link-text">Emergency Centers</span>
                    </a>
                    <ul id="emergency-centers" class="nav flex-column collapse collapse-level-1
                        {{Request::is('emergency-centers*')?'collapse show':''}}">
                        <li class="nav-item">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('emergency-centers.index') }}">All Centers</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('emergency-centers.create') }}">New Center</a>
                                </li>

                            </ul>
                        </li>
                    </ul>
                </li>

                <!--<li class="nav-item">
                    <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#dispatch-centers">
                        <span class="feather-icon"><i data-feather="list"></i></span>
                        <span class="nav-link-text">Dispatch Centers</span>
                    </a>
                    <ul id="dispatch-centers" class="nav flex-column collapse collapse-level-1
                        {{Request::is('dispatch-centers*')?'collapse show':''}}">
                        <li class="nav-item">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('dispatch-centers.index') }}">All Centers</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('dispatch-centers.create') }}">New Center</a>
                                </li>

                            </ul>
                        </li>
                    </ul>
                </li>





                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#stakeholders">
                        <span class="feather-icon"><i data-feather="list"></i></span>
                        <span class="nav-link-text">Stakeholders</span>
                    </a>
                    <ul id="stakeholders" class="nav flex-column collapse collapse-level-1
                        {{Request::is('stakeholders*')?'collapse show':''}}">
                        <li class="nav-item">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('stakeholders.index') }}">All Stakeholders</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('stakeholders.create') }}">New Stakeholder</a>
                                </li>

                            </ul>
                        </li>
                    </ul>
                </li>-->

                @can('Manage Users')
                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#pages_drp">
                        <span class="feather-icon"><i data-feather="users"></i></span>
                        <span class="nav-link-text">Users</span>
                    </a>
                    <ul id="pages_drp" class="nav flex-column collapse collapse-level-1
                        {{Request::is('users*')?'collapse show':''}}
                        {{Request::is('permissions*')?'collapse show':''}}
                        {{Request::is('roles*')?'collapse show':''}}">
                        <li class="nav-item">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('users.index') }}">Manage Users</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('permissions.index') }}">Manage Permissions</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('roles.index') }}">Manage Roles</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                @endcan

                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#audits">
                        <span class="feather-icon"><i data-feather="clock"></i></span>
                        <span class="nav-link-text">Reports</span>
                    </a>
                    <ul id="audits" class="nav flex-column collapse collapse-level-1
                        {{Request::is('reports*')?'collapse show':''}}">
                        <li class="nav-item">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Dispatch Reports</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Activity Reports</a>
                                </li>

                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>

        </div>
    </div>
</nav>
<div id="hk_nav_backdrop" class="hk-nav-backdrop"></div>
<!-- /Main Nav -->
