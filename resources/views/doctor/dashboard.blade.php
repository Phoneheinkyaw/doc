@extends('doctor.layout.dashboard')
@section('main-visual')
    @php
        use Illuminate\Support\Facades\Auth;
        $doctor = Auth::guard('doctors')->user();
    @endphp
    <div class="page-wrapper">
        <div class="content container-fluid pt-1 px-0">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-sm-6">
                                    <div class="page-title">
                                        Hello Dr.{{ $doctor->name }}
                                    </div>
                                </div>
                                <div class="rounded-md flex items-center justify-between">
                                    <div class="text-gray-800 font-medium">
                                        {{ \Carbon\Carbon::now()->format('F j, Y') }}
                                        <i class="fa fa-calendar ml-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="row">
                    <!-- First Row (4 Widgets) -->
                    <div class="col-md-3 col-sm-6 col-lg-3">
                        <div class="dash-widget dash-widget5 h-100">
                            <span class="float-left">
                                <img src="{{ asset('img/img_confirm.png') }}" alt="" width="60">
                            </span>
                            <div class="dash-widget-info text-right">
                                <h2>{{ count($confirmedAppointment) }}</h2>
                                <a href="{{ route('doctor.confirm.appointment') }}"
                                    class="text-md text-success">Confirmed</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-lg-3">
                        <div class="dash-widget dash-widget5 h-100">
                            <span class="float-left">
                                <img src="{{ asset('img/img_reject.png') }}" alt="" width="60">
                            </span>
                            <div class="dash-widget-info text-right">
                                <h2>{{ count($rejectedAppointment) ?? 'No Rejected Appointment' }}</h2>
                                <a href="{{ route('doctor.rejected.appointment') }}"
                                    class="text-md text-success">Rejected</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-lg-3">
                        <div class="dash-widget dash-widget5 h-100">
                            <span class="float-left">
                                <img src="{{ asset('img/img_missed.png') }}" alt="" width="60">
                            </span>
                            <div class="dash-widget-info text-right">
                                <h2>{{ count($missedAppointment) ?? 'No Today' }}</h2>
                                <a href="{{ route('doctor.missed.appointment') }}" class="text-md text-success">Missed</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-lg-3">
                        <div class="dash-widget dash-widget5 h-100">
                            <span class="float-left">
                                <img src="{{ asset('img/img_finished.png') }}" alt="" width="60">
                            </span>
                            <div class="dash-widget-info text-right">
                                <h2>{{ count($finishedAppointment) }}</h2>
                                <a href="{{ route('doctor.finished.appointment') }}"
                                    class="text-md text-success">Finished</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3 px-2 mt-1">
                    <div class="col-lg-8 p-2">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="mb-0">Pending Appointments <span class="text-primary">
                                            {{ count($pendingAppointment) }}</span>
                                    </h4>
                                    <a class="btn btn-primary btn-sm" href="{{ route('doctor.pending.appointment') }}">View
                                        All</a>
                                </div>
                                <table class="table custom-table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Date</th>
                                            <th>Patient</th>
                                            <th>Room</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($pendingAppointment->take(5) as $appointment)
                                            <tr>
                                                <td>{{ $appointment->id }}</td>
                                                <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') }}
                                                </td>
                                                <td>{{ $appointment->patient->name }}</td>
                                                <td>{!! $appointment->room ? $appointment->room->name : '<span class="text-secondary">No Room Booked</span>' !!}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No pending appointments available
                                                    for
                                                    display.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 p-2 d-flex flex-column align-items-stretch justify-content-between">
                        <div class="card mb-2 h-100">
                            <div class="card-body">
                                <h4 class="mb-2 mt-1">Upcoming Today</h4>
                                @php
                                    $upcomingAppointment = isset($todayAppointment[0]) ? $todayAppointment[0] : null;
                                @endphp
                                @if ($upcomingAppointment)
                                    <p class="mb-1 mt-3">Appointment ID: <span
                                            class="text-success">{{ $upcomingAppointment->id }}</span>
                                    </p>
                                    <p class="mb-1">Booked At:
                                        <strong>{{ \Carbon\Carbon::parse($upcomingAppointment->created_at)->format('d/m/Y') }}</strong>
                                    </p>
                                    <p class="mb-1">Patient: <span
                                            class="text-success">{{ $upcomingAppointment->patient->name }}</span>
                                    </p>
                                    <p class="mb-1">Room:
                                        @if ($upcomingAppointment->room_id)
                                            <span class="text-info">{{ $upcomingAppointment->room->name }}</span>
                                        @else
                                            <span class="text-secondary">No Room Booked</span>
                                        @endif
                                    </p>
                                @else
                                    <p class="mt-3 mb-0">No more upcoming appointment available for today.</p>
                                @endif
                                <a href="{{ route('doctor.today.appointment') }} "
                                    class="btn btn-link text-primary p-0 mt-2 btn-sm">view more<i
                                        class="ml-1 fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card mb-0 h-100">
                            <div class="card-body">
                                <h4 class="mb-2 mt-1">Next Appointment</h4>
                                @php
                                    $nextAppointment = $confirmedAppointment
                                        ->filter(function ($appointment) {
                                            return \Carbon\Carbon::parse($appointment->appointment_date)->gte(
                                                \Carbon\Carbon::today(),
                                            );
                                        })
                                        ->first();
                                @endphp
                                @if ($nextAppointment)
                                    <p class="mb-1">On
                                        <strong>{{ \Carbon\Carbon::parse($nextAppointment->appointment_date)->format('d/m/Y') }}</strong>
                                    </p>
                                    <p class="mb-1">Patient: <span
                                            class="text-success">{{ $nextAppointment->patient->name }}</span>
                                    </p>
                                    <p class="mb-1">Room:
                                        @if ($nextAppointment->room_id)
                                            <span class="text-info">{{ $nextAppointment->room->name }}</span>
                                        @else
                                            <span class="text-secondary">No Room Booked</span>
                                        @endif
                                    </p>
                                @else
                                    <p>No upcoming appointment available.</p>
                                @endif
                                <a href="{{ route('doctor.confirm.appointment') }} "
                                    class="btn btn-link text-primary p-0 mt-2 btn-sm">view more<i
                                        class="ml-1 fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-4 p-3 border-top">
            <p><strong>DOCTOR APPOINTMENT Contact:</strong> +959 21334343 | +959 324234324 | <a
                    href="http://localhost:8000/">info@DOCTOR APPOINTMENT.com</a>
            </p>
            <p><small>DOCTOR APPOINTMENT, Mandalay, Chanmyathazi Township</small></p>
            <p class="text-muted"><small>This record is confidential and intended solely for the patient and authorized
                    personnel. Any unauthorized review, use, or distribution is prohibited.</small></p>
        </div>
    </div>
@endsection
