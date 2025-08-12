@extends('patient.layout.dashboard')
@section('main-visual')
    @php
        $patient = Auth::guard('patients')->user();
    @endphp
    <div class="page-wrapper">
        <div class="row">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header w-100 d-flex justify-content-between align-items-center">
                        <h2>Update Profile</h2>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="pl-0 mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li class="list-unstyled py-1">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session('success') || session('editError') || session('deleteError'))
                            <div class="alert {{ session('success') ? 'alert-success' : 'alert-danger' }}">
                                @if (session('success'))
                                    {{ session('success') }}
                                @elseif (session('editError'))
                                    {{ session('editError') }}
                                @elseif (session('deleteError'))
                                    {{ session('deleteError') }}
                                @endif
                            </div>
                        @endif

                        <form action="{{ route('patient.update') }}" method="POST" autocomplete="off">
                            @csrf
                            @auth('patients')
                                <h4 class="my-3">Patient Id# <span
                                        class="text-success">{{ Auth::guard('patients')->id() }}</span>
                                </h4>
                                <h5 class="my-3">Joined At: <span
                                        class="text-success">{{ Auth::guard('patients')->user()->created_at }}</span>
                                </h5>
                                <h5 class="my-3">Last Updated At: <span
                                        class="text-success">{{ Auth::guard('patients')->user()->updated_at }}</span>
                                </h5>
                            @else
                                <p>You are not logged in.</p>
                            @endauth
                            <input type="text" id="id" name="id" hidden value="{{ $patient->id }}">
                            <div class="mb-3 mt-5">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name"
                                       class="form-control col-lg-5 @error('name') is-invalid @enderror"
                                       value="{{ old('name') ?? $patient->name }}">
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email">Email</label>
                                <input type="text" id="email" name="email"
                                       class="form-control col-lg-5 @error('email') is-invalid @enderror"
                                       value="{{ old('email') ?? $patient->email }}">
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="phone">Phone</label>
                                <input type="tel" id="phone" name="phone"
                                       class="form-control col-lg-5 @error('phone') is-invalid @enderror"
                                       value="{{ old('phone') ?? $patient->phone }}">
                                @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="address">Address</label>
                                <input type="text" id="address" name="address"
                                       class="form-control col-lg-5 @error('address') is-invalid @enderror"
                                       value="{{ old('address') ?? $patient->address }}">
                                @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>Gender</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="genderMale" name="gender" value=1
                                               class="form-check-input @error('gender') is-invalid @enderror"
                                            {{ old('gender') == 'male' || $patient->gender == 1 ? 'checked' : '' }}>
                                        <label for="genderMale" class="form-check-label">Male</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="genderFemale" name="gender" value=2
                                               class="form-check-input @error('gender') is-invalid @enderror"
                                            {{ old('gender') == 'female' || $patient->gender == 2 ? 'checked' : '' }}>
                                        <label for="genderFemale" class="form-check-label">Female</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="genderOther" name="gender" value=3
                                               class="form-check-input @error('gender') is-invalid @enderror"
                                            {{ old('gender') == 'other' || $patient->gender == 3 ? 'checked' : '' }}>
                                        <label for="genderFemale" class="form-check-label">Other</label>
                                    </div>
                                    @error('gender')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <a href="{{ route('patient.profile') }}" class="btn btn-gray mb-4">Back</a>
                            <button type="submit" class=" btn btn-primary mb-4">Update</button>
                        </form>
                        <form method="POST" action="{{ route('patient.destroy') }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <input type="text" id="id" name="id" hidden value="{{ $patient->id }}">
                            <button type="submit" class="btn btn-link text-danger px-0 my-4"
                                    onclick="return confirm('Are you sure you want to delete this profile?');">
                                Delete Profile
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
