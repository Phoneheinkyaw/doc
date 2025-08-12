@extends('doctor.layout.dashboard')
@section('main-visual')
<div class="page-wrapper mt-3">
    <div class="row">
        <!-- Appointment Record Table -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Appointment Record List for {{ $patient->name }}</h4>
                    <a href="{{ route('doctor.patient.list') }}" class="btn btn-gray">
                         Back
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Appointment Date</th>
                                    <th>Appointment Status</th>
                                    <th>Room</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($appointments as $appointment)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M, Y') }}</td>
                                        <td>
                                            @switch($appointment->status)
                                            @case(1)
                                                <p class="text-info font-weight-bold"> Pending</p>
                                            @break

                                            @case(2)
                                                <p class="text-danger font-weight-bold"> Rejected</p>
                                            @break

                                            @case(3)
                                                <p class="text-warning font-weight-bold"> Confirmed</p>
                                            @break

                                            @case(4)
                                                <p class="text-dark font-weight-bold"> Missed</p>
                                            @break

                                            @case(5)
                                                <p class="text-success font-weight-bold"> Finished</p>
                                            @break

                                            @case(6)
                                                <p class="text-danger font-weight-bold"> Canceled</p>
                                            @break
                                        @endswitch
                                        </td>
                                        <td>
                                            {!! $appointment->room
                                                ? '<span class="text-primary font-weight-bold">' . $appointment->room->name . '</span>'
                                                : '<span class="text-muted">No Room Booked</span>' !!}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">No appointments found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $appointments->links() }}
                    </div>
                </div>
            </div>
        </div>
           <!-- Patient Profile Card -->
           <div class="col-lg-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Patient Profile</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item mb-2">
                            <strong>Name:</strong> {{ $patient->name }}
                        </li>
                        <li class="list-group-item mb-2">
                            <strong>Phone:</strong> {{ $patient->phone ?? 'N/A' }}
                        </li>
                        <li class="list-group-item mb-2">
                            <strong>Email:</strong> {{ $patient->email ?? 'N/A' }}
                        </li>
                        <li class="list-group-item mb-2">
                            <strong>Address:</strong> {{ $patient->address ?? 'N/A' }}
                        </li>
                        <li class="list-group-item mb-2">
                            <strong>Gender:</strong>@if ($patient->gender !== null && isset(config('constants.genders')[$patient->gender]))
                            {{ config('constants.genders')[$patient->gender] }}
                        @else
                            Not specified
                        @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center mt-4 p-3 border-top">
        <p><strong>Hospital Contact:</strong> +959 947839478 | +959 944339478 | <a href="{{ url('/') }}">info@sakura.com</a></p>
        <p><small>123 SAKURA Hospital, Mandalay, Chanmyathazi Township</small></p>
        <p class="text-muted"><small>This record is confidential and intended solely for the patient and authorized personnel. Any unauthorized review, use, or distribution is prohibited.</small></p>
    </div>
</div>
@endsection
