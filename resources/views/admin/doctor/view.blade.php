@extends('admin.layout.dashboard')
@section('main-visual')
    <div class="page-wrapper">
        <div class="card shadow-sm p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-2">Doctor Information</h4>
                    <p><strong>ID: {{ $doctor->id }}</strong></p>
                </div>
                <img src="{{ asset('img/logo1.png') }}" alt="Hospital Logo" style="height: 80px;">
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    @if ($doctor->image)
                        <img src="{{ asset('storage/' . $doctor->image) }}" alt="Doctor Image" class="img-fluid rounded">
                    @else
                        <div class="text-center p-3 bg-light">No Image Available</div>
                    @endif
                </div>
                <div class="col-md-8">
                    <p><strong>Name:</strong> {{ $doctor->name }}</p>
                    <p><strong>Email:</strong> {{ $doctor->email }}</p>
                    <p><strong>Phone:</strong> {{ $doctor->phone }}</p>
                    <p><strong>Department:</strong> {{ $doctor->department->name }}</p>
                    <p><strong>License Number:</strong> {{ $doctor->licence_number }}</p>
                </div>
            </div>
        </div>
        <a href="{{ route('list.doctor') }}" class="btn btn-gray">Back</a>
        <div class="text-center mt-4 p-3 border-top">
            <p><strong>Hospital Contact:</strong> +959 942342444 | +959 943423443 | <a
                    href="http://localhost:8000/">info@doctor appointment.com</a></p>
            <p><small>Doctor Appointment, Mandalay, Chanmyathazi Township</small></p>
            <p class="text-muted"><small>This record is confidential and intended solely for authorized personnel. Any
                    unauthorized review, use, or distribution is prohibited.</small></p>
        </div>
    </div>
@endsection
