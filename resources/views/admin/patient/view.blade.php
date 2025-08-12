@extends('admin.layout.dashboard')

@section('main-visual')
    <div class="page-wrapper">
        <div class="card shadow-sm p-4 ">
            <div class="d-flex justify-content-between align-items-center ">
                <div>
                    <h4 class="mb-2">Patient Information</h4>
                    <p><strong> ID: {{ $patient->id }}</strong></p>
                </div>
                <img src="{{ asset('img/logo1.png') }}" alt="Hospital Logo" style="height: 80px;">
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Name:</strong> {{ $patient->name }}</p>
                    <p><strong>Email:</strong> {{ $patient->email }}</p>
                    <p><strong>Phone:</strong> {{ $patient->phone }}</p>
                    <p><strong>Address:</strong> {{ $patient->address }}</p>
                    <p><strong>Gender:</strong>
                        @if ($patient->gender !== null && isset(config('constants.genders')[$patient->gender]))
                            {{ config('constants.genders')[$patient->gender] }}
                        @else
                            Not specified
                        @endif
                    </p>
                </div>
            </div>
        </div>
        <a href="{{ route('list.patient') }}" class="btn btn-gray">Back</a>
        <div class="text-center mt-4 p-3 border-top">
            <p><strong>Hospital Contact:</strong> +959 947839478 | +959 944339478 | <a
                    href="http://localhost:8000/">info@sakura.com</a></p>
            <p><small>123 SAKURA Hospital, Mandalay, Chanmyathazi Township</small></p>
            <p class="text-muted"><small>This record is confidential and intended solely for the patient and authorized
                    personnel. Any unauthorized review, use, or distribution is prohibited.</small></p>
        </div>
    </div>
@endsection
