<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="https://laravel.com/img/favicon/favicon-16x16.png" type='image/x-icon'>
    <title>Dashboard</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>

<body>
    <div class="main-wrapper">
        <x-admin-header-component />
        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <div class="header-left">
                        <a href="#" class="logo">
                            <img src="{{ asset('img/logo1.png') }}" width="40" height="40" alt="">
                            <span class="text-uppercase">Hospital</span>
                        </a>
                    </div>
                    <ul class="sidebar-ul">
                        <li class="menu-title">Menu</li>
                        <li class="{{ request()->routeIs('list.patient') ? 'active' : '' }}">
                            <a href="{{ route('list.patient') }}"><img src="{{ asset('img/sidebar/icon-2.png') }}"
                                    alt="icon"><span>Patient</span></a>
                        </li>
                        <li class="{{ request()->routeIs('list.doctor') ? 'active' : '' }}">
                            <a href="{{ route('list.doctor') }}"><img src="{{ asset('img/sidebar/icon-2.png') }}"
                                    alt="icon">
                                <span>
                                    Doctor</span> <span class="menu-arrow"></span></a>
                        </li>
                        <li class="{{ request()->routeIs('list.department') ? 'active' : '' }}">
                            <a href="{{ route('list.department') }}"><img src="{{ asset('img/sidebar/icon-4.png') }}"
                                    alt="icon">
                                <span>
                                    Department</span> <span class="menu-arrow"></span></a>
                        </li>
                        <li class="{{ request()->routeIs('list.appointment') ? 'active' : '' }}">
                            <a href="{{ route('list.appointment') }}"><img src="{{ asset('img/sidebar/icon-6.png') }}"
                                    alt="icon">
                                <span>
                                    Appointment</span> <span class="menu-arrow"></span></a>
                        </li>
                        <li class="{{ request()->routeIs('list.room') ? 'active' : '' }}">
                            <a href="{{ route('list.room') }}"><img src="{{ asset('img/sidebar/icon-1.png') }}"
                                    alt="icon">
                                <span>
                                    Room</span> <span class="menu-arrow"></span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container">
            @yield('content')
        </div>
    </div>
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/room/modal.js') }}"></script>
</body>

</html>
