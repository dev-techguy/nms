<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="" name="description"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'EMS') }} - @yield('title', 'EMS')</title>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">

@stack('css')

<!-- Custom css -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">


    <style>
        .wizard > .steps > ul > li {
            margin-right: 10px;
        }

        .wizard .wizard-icon-wrap {
            height: 30px;
            width: 30px;
        }
    </style>
    @routes
    @livewireStyles
</head>

<body>

<!-- Preloader -->
<div class="preloader-it">
    <div class="loader-pendulums"></div>
</div>
<!-- /Preloader -->

<!-- HK Wrapper -->

<div class="hk-wrapper @yield('orientation')">

    @hasanyrole('Dispatcher|Watcher')
    @include('partials.topnavbar-watcher')
    @if(session()->get('usertype')=='Dispatcher')
        @include('partials.navbar-dispatcher')
    @else
        @include('partials.navbar-watcher')
    @endif
    @else
        @include('partials.topnavbar')
        @include('partials.navbar')
        @endhasanyrole

        <!-- Main Content -->
        <div class="hk-pg-wrapper">

            @yield('content')

            @include('partials.footer')

        </div>
        <!-- /Main Content -->

</div>
<!-- /HK Wrapper -->


<!-- jQuery -->
<script src="{{ asset('vendors/jquery/dist/jquery.min.js') }}"></script>

<!-- Bootstrap Core JavaScript -->
<script src="{{ asset('vendors/popper.js/dist/umd/popper.min.js') }}"></script>
<script src="{{ asset('vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>

<!-- Slimscroll JavaScript -->
<script src="{{ asset('js/jquery.slimscroll.js') }}"></script>

<!-- Fancy Dropdown JS -->
<script src="{{ asset('js/dropdown-bootstrap-extended.js') }}"></script>

<!-- FeatherIcons JavaScript -->
<script src="{{ asset('js/feather.min.js') }}"></script>

<!-- Tablesaw JavaScript -->
<script src="{{ asset('vendors/tablesaw/dist/tablesaw.jquery.js') }}"></script>
<script src="{{ asset('js/tablesaw-data.js') }}"></script>

<!-- Toggles JavaScript -->
<script src="{{ asset('vendors/jquery-toggles/toggles.min.js') }}"></script>
<script src="{{ asset('js/toggle-data.js') }}"></script>

<script>

    $(document).ready(function () {

        /*$('input[required]').css("border-color", "red");
         $('input[required="required"]').css("border-color", "red");
         $('input[required="true"]').css("border-color", "red");
         $('input:required').css("border-color", "red");*/

        $('input:required, select:required, textarea:required').each(function () {
            var label = $(this).closest("div").find("label")
                .append(' <i class="text-danger"> *</i>');
        });
    });

</script>

@stack('js')

<!-- Init JavaScript -->
<script src="{{ asset('js/init.js') }}"></script>

@stack('js-extended')
@livewireScripts

</body>

</html>
