<!doctype html>
<html lang="en">
<script lang="{{ str_replace('_', '-', app()->getLocale()) }}"></script>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Affan - PWA Mobile HTML Template">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#0134d4">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <!-- Title -->
    <title>
        @yield('title')
    </title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" href="{{asset('img/icons/pizza-bg-96x96.png')}}">
    <link rel="apple-touch-icon" href="../../public/img/icons/pizza-bg-96x96.png">
    <link rel="apple-touch-icon" sizes="152x152" href="../../public/img/icons/pizza-bg-152x152.png">
    <link rel="apple-touch-icon" sizes="167x167" href="../../public/img/icons/pizza-bg-167x167.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../../public/img/icons/pizza-bg-180x180.png">
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-icons.css')}}">
    <link rel="stylesheet" href="{{asset('css/tiny-slider.css')}}">
    <link rel="stylesheet" href="{{asset('css/baguetteBox.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/rangeslider.css')}}">
    <link rel="stylesheet" href="{{asset('css/vanilla-dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/apexcharts.css')}}">
    <!-- Core Stylesheet -->
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <!-- Web App Manifest -->
    <link rel="manifest" href="{{asset('manifest.json')}}">
</head>
<body>
    @yield('content')
</body>
@yield('scripts')
</html>
