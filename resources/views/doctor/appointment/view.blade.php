@extends('doctor.layout.dashboard')
@section('main-visual')
    <div class="page-wrapper">
        <div class="card shadow-sm p-4 mb-4">
            @if (
                $appointment->status === config('constants.statuses.rejected') ||
                    $appointment->status === config('constants.statuses.canceled') ||
                    $appointment->status === config('constants.statuses.pending'))
                <p class="text-danger text-center">This appointment is yet to be issued by the doctor!</p>
            @endif
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h4 class="mb-0">Appointment Record</h4>
                    <p class="text-muted">Appointment ID: {{ $appointment->id }}</p>
                </div>
                <img src="{{ asset('img/logo1.png') }}" alt="Hospital Logo" style="height: 80px;">
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <h5>Patient Information</h5>
                    <p><strong>Name:</strong> {{ $appointment->patient->name }}</p>
                    <p><strong>Email:</strong> {{ $appointment->patient->email }}</p>
                    <p><strong>Phone:</strong> {{ $appointment->patient->phone }}</p>
                    <p><strong>Address:</strong> {{ $appointment->patient->address }}</p>
                    <p><strong>Gender:</strong> {{ config('constants.genders')[$appointment->patient->gender] }}</p>
                </div>
                <div class="col-md-6">
                    <h5>Doctor Information</h5>
                    <p><strong>Name:</strong> Dr. {{ $appointment->doctor->name }}</p>
                    <p><strong>Email:</strong> {{ $appointment->doctor->email }}</p>
                    <p><strong>Phone:</strong> {{ $appointment->doctor->phone }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h5>Appointment Details</h5>
                    <p>
                        <strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') }}
                    </p>
                    <p><strong>Status:</strong>
                        {{ ucwords(array_keys(config('constants.statuses'))[$appointment->status - 1]) }}
                    </p>
                </div>
                <div class="col-md-6 d-flex align-items-center">
                    <img src="{{ asset('img/img_hospital_signature.png') }}" alt="Appointment Icon" class="img-fluid"
                        style="max-width: 150px;">
                </div>
            </div>
        </div>
        <a href="{{ route('doctor.appointment.list', ['patientId' => $appointment->patient_id]) }}"
            class="btn btn-gray">Back</a>
        <div class="text-center mt-4 p-3 border-top">
            <p><strong> Contact:</strong> +959 94744533 | +959 9443344228 | <a
                    href="http://localhost:8000/">info@SayKhann.com</a>
            </p>
            <p><small>Mandalay, Chanmyathazi Township</small></p>
            <p class="text-muted"><small>This record is confidential and intended solely for the patient and authorized
                    personnel. Any unauthorized review, use, or distribution is prohibited.</small></p>
        </div>
    </div>
@endsection
