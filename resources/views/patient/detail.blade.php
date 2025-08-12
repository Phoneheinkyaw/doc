@extends('patient.layout.dashboard')
@section('main-visual')
    <div class="page-wrapper">
        <div class="card shadow-sm p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h4 class="mb-0">Appointment Record</h4>
                </div>
                <img src="{{ asset('img/logo1.png') }}" alt="Hospital Logo" style="height: 80px;">
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <h5>Patient Information</h5>
                    <p><strong>Name:</strong> {{ $patient->name }}</p>
                    <p><strong>Doctor:</strong> {{ $patient->doctors->name }}</p>
                    <p><strong>Room:</strong> {{ $patient->rooms->name }}</p>
                    <p><strong>Date:</strong> {{ $patient->appointments->appointment_date }}</p>
                    <p><strong>Status:</strong>
                        @switch($patient->appointments->status)
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
                    </p>
                </div>
            </div>
        </div>
        <a href="{{ route('patient.index') }}" class="btn btn-gray">Back</a>
        <div class="text-center mt-4 p-3 border-top">
            <p><strong>Hospital Contact:</strong> +959 21334343 | +959 324234324 | <a
                    href="http://localhost:8000/">info@Doctor Appointment.com</a>
            </p>
            <p><small>Doctor Appointment, Mandalay, Chanmyathazi Township</small></p>
            <p class="text-muted"><small>This record is confidential and intended solely for the patient and authorized
                    personnel. Any unauthorized review, use, or distribution is prohibited.</small></p>
        </div>
    </div>
@endsection
