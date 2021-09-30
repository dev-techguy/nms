<!-- Main Nav -->
<nav class="hk-nav hk-nav-light">
    <a href="javascript:void(0);" id="hk_nav_close" class="hk-nav-close"><span class="feather-icon"><i data-feather="x"></i></span></a>
    <div class="nicescroll-bar">
        <div class="navbar-nav-wrap container">
            <ul class="navbar-nav @yield('navbardirection', 'flex-column')">
                @can('Read Watchers Panel')
                <li class="nav-item">
                    <a class="nav-link" href="{{route('watchers.dashboard')}}" >
                        <span class="feather-icon"><i data-feather="activity"></i></span>
                        <span class="nav-link-text">Dashboard</span>
                    </a>

                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('incidents.index') }}" >
                        <span class="feather-icon"><i data-feather="target"></i></span>
                        <span class="nav-link-text">Cases</span>
                    </a>
                </li>


                 <li class="nav-item">
                    <a class="nav-link" href="{{route('watchers.report')}}" >
                        <span class="feather-icon"><i data-feather="clipboard"></i></span>
                        <span class="nav-link-text">Reports</span>
                    </a>
                </li>
                @endcan


            </ul>

        </div>

    </div>
</nav>
<div id="hk_nav_backdrop" class="hk-nav-backdrop"></div>
<!-- /Main Nav -->