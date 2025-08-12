@extends('patient.layout.common')
@section('content')
    <div class="container">
        <div class="left-col">
            <h4 class="text-center">Forgot Password</h4>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert-box">
                        {{ session('status') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('password.request') }}">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email') }}" placeholder="Enter your email address.">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-blue w-100 my-3">Submit</button>
                </form>
            </div>
        </div>
        <div class="right-col">
            <i class="fas fa-envelope fa-5x mb-4"></i>
            
            <p>Enter your email address below, and we'll send you a link to reset your password.</p>
        </div>
    </div>
@endsection
