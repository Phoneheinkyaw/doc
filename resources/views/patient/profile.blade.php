@extends('patient.layout.dashboard')
@section('main-visual')
    @php
        $patient = Auth::guard('patients')->user();
    @endphp
    <div class="page-wrapper">
        <div class="container my-5">
            <div class="profile_success">
                <div id="success_message">
                     @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 mt-5">
                    <div class="card profile-card p-4 shadow-sm position-relative">
                        <div class="d-flex justify-content-center mb-3 position-relative">
                            <img id="profileImagePreview"
                            src="{{asset('img/profile/profile.png') }}"
                            alt="Profile Picture" class="rounded-circle" width="120" height="120">
                        </div>
                        <div class="">
                            <div class="ml-3 d-flex align-items-center mb-3">
                                <p class="font-weight-bold mb-0 mr-2">Name:</p>
                                <h5 id="profileNamePreview" class="mb-0">
                                    {{ $patient->name ?? 'User Name' }}</h5>
                            </div>

                            <div class="ml-3 d-flex align-items-center mb-3">
                                <p class="font-weight-bold mb-0 mr-2">Email:</p>
                                <p id="profileEmailPreview" class="mb-0 text-muted">
                                    {{ $patient->email ?? 'your-email@example.com' }}</p>
                            </div>

                            <div class="ml-3 d-flex align-items-center mb-3">
                                <p class="font-weight-bold mb-0 mr-2">Phone:</p>
                                <p class="mb-0 text-muted">{{ $patient->phone ?? '09-885672201' }}</p>
                            </div>

                            <div class="ml-3 d-flex align-items-center mb-3">
                                <p class="font-weight-bold mb-0 mr-2">Address:</p>
                                <p class="mb-0 text-muted">
                                    {{ $patient->address ?? 'Address' }}</p>
                            </div>
                            <div class="ml-3 d-flex align-items-center mb-3">
                                <p class="font-weight-bold mb-0 mr-2">Joined At:</p>
                                <p class="mb-0 text-muted">
                                    {{ $patient->created_at ?? 'Address' }}</p>
                            </div>
                            <div class="ml-3 d-flex align-items-center mb-3 justify-content-between">
                                <a href="{{ route('patient.update') }}"
                                    class="btn btn-success  text-sm  px-2 py-1">Edit
                                    Profile</a>
                                <a href="{{ route('patient.edit-password') }}"
                                    class="btn btn-success  text-sm  px-2 py-1">
                                    Change Password</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
