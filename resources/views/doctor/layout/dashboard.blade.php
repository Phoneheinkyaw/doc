@extends('doctor.layout.app')
@section('content')
    <div class="main-wrapper">
        <x-doctor-header-component />
        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <div class="header-left">
                        <a href="{{ route('doctor.dashboard') }}" class="logo">
                            <img src="{{ asset('img/logo1.png') }}" width="40" height="40" alt="">
                    
                        </a>
                    </div>
                    <ul class="sidebar-ul">
                        <li class="menu-title">Menu</li>
                        <li
                            class="{{ Route::is('doctor.dashboard', 'doctor.profile', 'doctor.change.psw', 'doctor.upload.psw', 'doctor.missed.appointment', 'doctor.today.appointment', 'doctor.rejected.appointment', 'doctor.confirm.appointment', 'doctor.pending.appointment', 'doctor.finished.appointment') ? 'active' : '' }}">
                            <a href="{{ route('doctor.dashboard') }}">
                                <i class="fas fa-th-large fa-5x"></i>
                                <span>Dashboard</span><span class="menu-arrow"></span></a>
                        </li>
                        <li class="{{ Route::is('doctor.appointment.list', 'doctor.appointment.view') ? 'active' : '' }}">
                            <a href="{{ route('doctor.appointment.list') }}">
                                <i class="fas fa-calendar-alt"></i>
                                <span> Appointment</span> <span class="menu-arrow"></span></a>
                        </li>
                        <li
                            class="{{ Route::is('doctor.patient.list', 'doctor.patient.appointment.record') ? 'active' : '' }}">
                            <a href="{{ route('doctor.patient.list') }}">
                                <i class="fas fa-notes-medical fa-5x"></i>
                                <span> Patient Record</span> <span class="menu-arrow"></span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container-fluid my-3">
            @yield('main-visual')
        </div>
    </div>
@endsection
