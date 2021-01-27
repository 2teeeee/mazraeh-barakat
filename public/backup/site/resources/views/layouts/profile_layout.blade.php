<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery-3.3.1.js') }}"></script>

    <script src="{{ asset('bootstrap/dist/js/bootstrap.js') }}" defer></script>
    <script src="{{ asset('bootstrap/js/dist/util.js') }}" defer></script>
    <script src="{{ asset('js/fa.js') }}" defer></script>
    <script src="{{ asset('js/flipclock.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}" type="text/javascript"></script>
<!-- Styles -->
    <link href="{{ asset('bootstrap/dist/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}?v=2" rel="stylesheet">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('fontawesome/css/all.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/flipclock.css') }}">
    <link rel="stylesheet" href="{{ asset('css/rating.css') }}">
    
    <link rel="stylesheet" href="{{ asset('css/persianDatepicker.css') }}" />
    <script src="{{ asset('js/persianDatepicker.js') }}"></script>
    
</head>
<body class="bg-body">
    @include('layouts.main.head')
    @include('layouts.profile.breadcrumb')
    
    <div class="container px-0 pt-2 jumbotron mt-2 bg-transparent">
        
        @include("layouts.profile.index")
        
    </div>
    <div class="container mb-2 px-0">
        @include('layouts.admin.button')
    </div>
    @include('layouts.main.footer')
    @yield('script') 
</body>
</html>