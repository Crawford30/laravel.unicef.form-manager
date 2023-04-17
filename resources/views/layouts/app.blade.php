<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Program, Planning &amp; Monitoring</title>

    <!-- Scripts -->
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCBE7aRb0VJdRBlUnvjcQ_lnKWoAWuXUx8&libraries=places,geometry"
        async defer></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="{{ asset('js/custom_events.min.js') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="body-bg"
    style="height: 100vh; font-family: 'Poppins', 'sans-serif' !important; overflow-y: hidden !important;">

    <div class="d-flex" id="app" v-cloak>

        <!-- Sidebar -->
        @include('layouts.sidenav')
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">

            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom shadow-sm">

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                        <li class="nav-item active">
                            <a class="nav-link username-link text-muted" href="#">Welcome
                                {{ auth()->user()->name }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" @click.prevent="openOrCloseMenu()" href="#"
                                style="font-size: 22px;"><i class="fa fa-bars" style="color: #999999;"></i></a>
                        </li>
                    </ul>
                    @include('layouts.menu')
                </div>
            </nav>

            <div class="container-fluid content-bg unicef-content-container px-3 py-2">
                @yield('content')

                {{-- Copywright and Support link at the page footer --}}
                <div class="col-12 my-4">
                    <hr>

                    <p class="m-0 text-center" style="color:gray">&copy; {{ date('Y') }} UNICEF Malawi. All rights
                        reserved
                    </p>

                    <p class="m-0 text-center"><a style="color: blue"
                            href="{{ env('SUPPORT_APP_URL') }}/login-from-bottom-support?token={{ encrypt(Auth::id()) }}&userId={{ Auth::id() }}">Support
                        </a>
                    </p>
                </div>
            </div>



            <export-data></export-data>

        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    {{-- MAIN PLATFORM URL --}}
    <input hidden id="platform-url" value="{{ env('PLATFORM_URL') }}">
    <input hidden id="faceform-url" value="{{ env('FACEFORM_URL') }}">

    @stack('custom-script')

</body>

</html>
