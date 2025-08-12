@extends('patient.layout.register')
@section('content')
    <div class="container">
        <div class="left-col">
            <h4 class="text-center">Patient Register</h4>
            <div class="card-body">
                <form action="{{ route('patient.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name"
                            class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input type="text" id="email" name="email"
                            class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password"
                            class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone">Phone</label>
                        <input type="tel" id="phone" name="phone"
                            class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="address">Address</label>
                        <textarea id="address" name="address" class="form-control @error('address') is-invalid @enderror">{{ old('address') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label>Gender</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input type="radio" id="genderMale" name="gender" value=1 class="form-check-input"
                                    {{ old('gender') == 1 ? 'checked' : '' }}>
                                <label for="genderMale" class="form-check-label">Male</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" id="genderFemale" name="gender" value=2 class="form-check-input"
                                    {{ old('gender') == 2 ? 'checked' : '' }}>
                                <label for="genderFemale" class="form-check-label">Female</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" id="genderOther" name="gender" value=3 class="form-check-input"
                                    {{ old('gender') == 3 ? 'checked' : '' }}>
                                <label for="genderOther" class="form-check-label">Other</label>
                            </div>
                            @error('gender')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-blue w-100 mb-4">Register</button>
                    <p class="text-center">Already have an account?
                        <a href="{{ route('patient.login') }}" class="color-white"> Log In</a>
                    </p>
                </form>
            </div>
        </div>
        <div class="right-col">
            <i class="fas fa-user-edit fa-5x mb-4"></i>
            
            <p>Please log in to access your dashboard, manage patient records, and handle appointments securely.</p>
        </div>
    </div>
@endsection
