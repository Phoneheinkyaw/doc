@extends('admin.layout.dashboard')
@section('main-visual')
    <div class="page-wrapper">
        <div class="card shadow-sm p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-2">Department Information</h4>
                    <p><strong>ID: {{ $department->id }}</strong></p>
                </div>
                <img src="{{ asset('img/logo1.png') }}" alt="Hospital Logo" style="height: 80px;">
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <p><strong>Name:</strong> {{ $department->name }}</p>
                    <p><strong>Description:</strong></p>
                    <div class="rounded">
                        <p class="text-break mb-0">{{ $department->description }}</p>
                    </div>
                </div>
            </div>
        </div>
        <a href="{{ route('list.department') }}" class="btn btn-gray">Back</a>
        <div class="text-center mt-4 p-3 border-top">
            <p><strong>Hospital Contact:</strong> +959 947839478 | +959 944339478 | <a
                    href="http://localhost:8000/">info@DOCTOR APPOINTMENT.com</a></p>
            <p><small>DOCTOR APPOINTMENT, Mandalay, Chanmyathazi Township</small></p>
            <p class="text-muted"><small>This record is confidential and intended solely for authorized personnel. Any
                    unauthorized review, use, or distribution is prohibited.</small></p>
        </div>
    </div>
@endsection
