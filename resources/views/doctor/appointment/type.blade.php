@extends('doctor.layout.dashboard')

@section('main-visual')
    <div class="page-wrapper mt-3">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Appointment Detail Information</h4>
                        <a href="{{ route('doctor.dashboard') }}" class="btn btn-gray"> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table custom-table table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Patient Name</th>
                                    <th>Appointment Date</th>
                                    <th>Room Name</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($appointments->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center fw-bold">
                                            No List Here
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($appointments as $appointment)
                                        <tr>
                                            <td>{{ $appointment->id }}</td>
                                            <td>{{ $appointment->patient->name }}</td>
                                            <td>{{ date('d M Y', strtotime($appointment->appointment_date)) }}</td>
                                            <td>{!! $appointment->room ? $appointment->room->name : '<span class="text-secondary">No Room Booked</span>' !!}</td>
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
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-4 p-3 border-top">
            <p><strong>DOCTOR APPOINTMENT Contact:</strong> +959 947839478 | +959 944339478 | <a
                    href="http://localhost:8000/">info@DOCTOR APPOINTMENT.com</a>
            </p>
            <p><small> DOCTOR APPOINTMENT, Mandalay, Chanmyathazi Township</small></p>
            <p class="text-muted"><small>This record is confidential and intended solely for the patient and authorized
                    personnel. Any unauthorized review, use, or distribution is prohibited.</small></p>
        </div>
    </div>
@endsection
