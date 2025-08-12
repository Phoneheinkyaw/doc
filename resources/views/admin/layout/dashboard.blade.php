@extends('admin.layout.app')
@section('content')
    <div class="main-wrapper">
        <x-admin-header-component />
        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <div class="header-left">
                        <a href="{{ route('list.patient') }}" class="logo">
                            <img src="{{ asset('img/logo1.png') }}" width="40" height="40" alt="">
                         
                        </a>
                    </div>
                    <ul class="sidebar-ul">
                        <li class="menu-title">Menu</li>
                        <li
                            class="{{ request()->routeIs('list.patient', 'admin.patient.view', 'admin.profile') ? 'active' : '' }}">
                            <a href="{{ route('list.patient') }}">
                                <i class="fas fa-procedures"></i>
                                <span>Patient</span><span class="menu-arrow"></span>
                            </a>
                        </li>

                        <li
                            class="{{ request()->routeIs('list.doctor', 'create.doctor', 'edit.doctor', 'admin.doctor.view') ? 'active' : '' }}">
                            <a href="{{ route('list.doctor') }}">
                                <i class="fas fa-user-md"></i>
                                <span>Doctor</span><span class="menu-arrow"></span>
                            </a>
                        </li>

                        <li
                            class="{{ request()->routeIs('list.department', 'create.department', 'edit.department', 'admin.department.view', 'search.department') ? 'active' : '' }}">
                            <a href="{{ route('list.department') }}">
                                <i class="fas fa-building"></i>
                                <span>Department</span> <span class="menu-arrow"></span></a>
                        </li>
                        <li class="{{ request()->routeIs('list.appointment', 'admin.appointment.view') ? 'active' : '' }}">
                            <a href="{{ route('list.appointment') }}">
                                <i class="fas fa-calendar-alt"></i>
                                <span>Appointment</span> <span class="menu-arrow"></span></a>
                        </li>
                        <li class="{{ request()->routeIs('list.room', 'create.room', 'edit.room') ? 'active' : '' }}">
                            <a href="{{ route('list.room') }}">
                                <i class="fas fa-door-closed"></i>
                                <span>Room</span> <span class="menu-arrow"></span></a>
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
