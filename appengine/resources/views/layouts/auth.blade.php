<!DOCTYPE html>
<html style="height: 100%;" lang="en">
<head>
    <meta charset="utf-8">
    <title>
        @yield('title') | Manajemen Kondektur
    </title>
    <meta name="description" content="Login">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="msapplication-tap-highlight" content="no">
    <link rel="stylesheet" media="screen, print" href="{{ asset('back-end/css/vendors.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ asset('back-end/css/app.bundle.css') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url(getSettingData('favicon')->value ?? '') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url(getSettingData('favicon')->value ?? '') }}">
    <link rel="mask-icon" href="{{ url(getSettingData('favicon')->value ?? '') }}" color="#5bbad5">
    <link rel="stylesheet" media="screen, print" href="{{ asset('back-end/css/page-login.css') }}">
</head>
<style>
    .my-bg {
        /* The image used */
        background-image: url('{{url('img/kai_bg.jpg')}}');

        /* Full height */
        height: 100%;

        /* Center and scale the image nicely */
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
</style>
<body style="height: 100%;">
<div class="my-bg">
    @yield('content')
</div>

<script src="{{ asset('back-end/js/vendors.bundle.js') }}"></script>
<script src="{{ asset('back-end/js/app.bundle.js') }}"></script>
@stack('content')
</body>
</html>
