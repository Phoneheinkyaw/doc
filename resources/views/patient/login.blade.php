@extends('patient.layout.common')
@section('content')
<div class="container">
    <div class="left-col">
        <h4 class="text-center">Patient Login</h4>
        <div class="card-body">
            <form method="POST" action="{{ route('patient.authenticate') }}">
                @csrf
                <div class="form-group mb-3">
                    <label for="email">Email Address</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="password">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <a href="{{ route('password.request') }}" class="color-white underline">Forgot Password?</a>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <a href="{{ route("welcome") }}" class="color-white">Home</a>
                    <button type="submit" class="btn btn-blue">Login</button>
                </div>
                <p class="text-center mt-3">Don&apos;t have an account?
                    <a href="{{ route('patient.create') }}" class="color-white underline"> Register</a>
                </p>
            </form>
        </div>
    </div>
    <div class="right-col">
        <i class="fas fa-procedures fa-5x mb-4"></i>
        
        <p>Please log in to access your dashboard, manage patient records, and handle appointments securely.</p>
    </div>
</div>
@endsection
