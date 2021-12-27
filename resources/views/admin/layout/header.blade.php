<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    @yield('admin_title')

    <link type="text/css" rel="stylesheet" href="{{asset('assets/backend/plugins/font-awesome/css/font-awesome.min.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('assets/backend/css/adminlte.min.css')}}">
    <link type="text/css" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="{{asset('assets/backend/css/bootstrap-rtl.min.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('assets/backend/css/custom-style.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('assets/common/plugins/toast/css/toast.min.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('assets/common/plugins/validation/css/validate.css')}}">
    <link type="text/css" href="{{asset('assets/common/css/common.css')}}" rel="stylesheet"/>

    <link rel="apple-touch-icon" sizes="152x152" href="{{asset('assets/common/images/logo/apple-touch-icon.png')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('assets/common/images/logo/android-chrome-512x512.png')}}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{asset('assets/common/images/logo/android-chrome-192x192.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/common/images/logo/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/common/images/logo/favicon-16x16.png')}}">
    <link rel="icon" href="{{asset('assets/common/images/logo/favicon.ico')}}" type="image/x-icon">

    @yield('admin_css')

</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
            </li>
        </ul>

        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a title="خروج" class="nav-link text-danger" href="{{route('logout')}}"><i
                        class="fa fa-sign-out"></i></a>
            </li>
        </ul>
    </nav>
