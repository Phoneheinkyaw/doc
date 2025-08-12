@extends('patient.layout.app')
@section('content')
    <div class="main-wrapper">
        <x-patient-header-component />
        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <div class="header-left">
                        <a href="{{ route('patient.index') }}" class="logo">
                            <img src="{{ asset('img/logo1.png') }}" width="40" height="40" alt="">
                   
                        </a>
                    </div>
                    <ul class="sidebar-ul">
                        <li class="menu-title">Menu</li>
                        <li
                            class="{{ Request::is('patient', 'patient/profile', 'patient/update', 'patient/change-password') ? 'active' : '' }}">
                            <a href="{{ route('patient.index') }}">
                                <i class="fas fa-th-large fa-5x "></i>
                                <span>Dashboard</span><span class="menu-arrow"></span>
                            </a>
                        </li>
                        <li
                            class="{{ Route::is('patient.get-all-appointment', 'appointment.create', 'appointment.detail') ? 'active' : '' }}">
                            <a
                                href="{{ route('patient.get-all-appointment', ['patientId' => Auth::guard('patients')->user()->id]) }}">
                                <i class="fas fa-calendar-alt"></i>
                                <span>Appointment</span><span class="menu-arrow"></span>
                            </a>
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
