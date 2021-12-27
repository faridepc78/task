<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('site_title')

    <link rel="apple-touch-icon" sizes="57x57" href="{{asset('assets/common/images/logo/apple-icon-57x57.png')}}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{asset('assets/common/images/logo/apple-icon-60x60.png')}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{asset('assets/common/images/logo/apple-icon-72x72.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('assets/common/images/logo/apple-icon-76x76.png')}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{asset('assets/common/images/logo/apple-icon-114x114.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{asset('assets/common/images/logo/apple-icon-120x120.png')}}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{asset('assets/common/images/logo/apple-icon-144x144.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{asset('assets/common/images/logo/apple-icon-152x152.png')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('assets/common/images/logo/apple-icon-180x180.png')}}">
    <link rel="icon" type="image/png" sizes="192x192"
          href="{{asset('assets/common/images/logo/android-icon-192x192.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/common/images/logo/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('assets/common/images/logo/favicon-96x96.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/common/images/logo/favicon-16x16.png')}}">
    <link rel="icon" href="{{asset('assets/common/images/logo/favicon.ico')}}" type="image/x-icon">
    <link rel="manifest" href="{{asset('assets/common/images/logo/manifest.json')}}">

    <link type="text/css" rel="stylesheet" href="{{asset('assets/frontend/css/bootstrap-rtl.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('assets/frontend/css/font-awesome.min.css')}}">
    <link type="text/css" href="{{asset('assets/frontend/css/style.css')}}" rel="stylesheet"/>
    <link type="text/css" href="{{asset('assets/common/plugins/toast/css/toast.min.css')}}" rel="stylesheet"/>
    <link type="text/css" href="{{asset('assets/common/css/common.css')}}" rel="stylesheet"/>
    <link type="text/css" href="{{asset('assets/backend/css/custom-style.css')}}" rel="stylesheet"/>

    @yield('site_css')

</head>

<body class="profile-page" data-spy="scroll" data-target=".navbar" data-offset="50">

<header id="header">
    <nav class="navbar navbar-transparent navbar-fixed-top navbar-color-on-scroll">
        <div class="container-fluid">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <div class="collapse navbar-collapse" id="navigation-example">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="{{route('home')}}">صفحه اصلی</a></li>
                    <li><a href="{{route('login')}}">ورود</a></li>

                    @auth()
                        <li><a href="{{route('logout')}}">خروج</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    @auth()
        <img id="profilePic" src="{{auth()->user()->profile}}" alt="profile">
        <div class="container-fluid" id="subheader">
            <div class="row" id="row">
                <div class="col-md-12">
                    <h1 id="name">{{auth()->user()->fullName}}</h1>
                </div>
            </div>
        </div>
    @endauth

</header>
