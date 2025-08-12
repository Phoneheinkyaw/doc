@extends('patient.layout.common')
@section('content')
    <div class="container">
        <div class="left-col">
            <h4 class="text-center">Reset Password</h4>
            <div class="card-body">
                <form action="{{ route('password.update') }}" method="POST" autocomplete="off">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" id="email" name="email" value="{{ $email }}">
                    <div class="mb-3">
                        <label for="password">New Password</label>
                        <input type="password" id="password" name="password"
                            class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="form-control @error('password_confirmation') is-invalid @enderror">
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-blue w-100 mb-4">Reset Password</button>
                </form>
            </div>
        </div>
        <div class="right-col">
            <i class="fas fa-lock fa-5x mb-4"></i>
        
            <p>Enter your email, password, and confirm your password to create a secure account.</p>
        </div>
    </div>
@endsection
