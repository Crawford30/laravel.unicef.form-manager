<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Program, Planning &amp; Monitoring</title>

    <!-- Scripts -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCBE7aRb0VJdRBlUnvjcQ_lnKWoAWuXUx8&libraries=places,geometry" async defer></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="{{ asset('js/custom_events.min.js') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container-fluid px-4">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img class="img-logo" src="{{asset("images/unicef.logo.blue.png")}}">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @if(auth()->check())
                            <li class="nav-item">
                                <a class="nav-link username-link text-muted" href="#" >{{ Auth::user()->name }}</a>
                            </li>
                            <li class="nav-item" style="position: relative">
                                <a class="nav-link" @click.prevent="openOrCloseMenu()" href="#" style="font-size: 22px;"><i class="fa fa-bars" style="color: #999999;"></i></a>
                                @include("layouts.menu")
                            </li>
                        @else
                            <li class="nav-item" style="position: relative">
                                <a class="nav-link" href="#" style="font-size: 22px;"><i class="fa fa-bars" style="color: #999999;"></i></a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>

        {{--SET MODULE URLS --}}
        <input hidden id="platform-url" value="{{env("PLATFORM_URL")}}">
        <input hidden id="faceform-url" value="{{env("FACEFORM_URL")}}">

    </div>

    @stack('custom-script')
</body>
</html>
