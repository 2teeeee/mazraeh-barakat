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
    <!-- Styles -->
    <link href="{{ asset('bootstrap/dist/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('fontawesome/css/all.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/flipclock.css') }}">
    
    <!-- ONLY INCLUDE IF YOU NOT HAVE THOSE DEPENDENCIES -->
    <link rel="stylesheet" href="vendor/rafwell/simple-grid/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />
    <!-- CSS LARAVEL SIMPLEGRID -->
    <link rel="stylesheet" href="vendor/rafwell/simple-grid/css/simplegrid.css">
    <!-- ONLY INCLUDE IF YOU NOT HAVE THOSE DEPENDENCIES -->
    <script src="vendor/rafwell/simple-grid/moment/moment.js"></script>
    <script type="text/javascript" src="vendor/rafwell/simple-grid/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <!-- JS LARAVEL SIMPLEGRID -->
    <script src="vendor/rafwell/simple-grid/js/simplegrid.js"></script>
    
    <link rel="stylesheet" href="{{ asset('css/persianDatepicker.css') }}" />
    <script src="{{ asset('js/persianDatepicker.js') }}"></script>
    
	@yield('styles') 
    
    
</head>
<body class="bg-body">
<!--    <div class="col-12 p-1" style="background: #d1ecf1;color:#FFFFFF;">
        <a href="http://mazraehapp.ir/mazraehApp.apk">
            <img src="{{ asset('image/icon/smartphone.png') }}" style="width:64px" />
        دانلود اپلیکیشن مزرعه
        </a>
    </div>-->
    @include('layouts.main.head')
    
    @yield('content')
    
    @include('layouts.main.footer')
    @yield('script') 
    
</body>
</html>
