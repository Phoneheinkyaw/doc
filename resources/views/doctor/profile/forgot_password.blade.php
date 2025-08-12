<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="https://laravel.com/img/favicon/favicon-16x16.png" type='image/x-icon'>
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('doctor/css/style.css') }}">
</head>

<body>
    <div class="container">
        <div class="left-col">
            <h4 class="text-center">Forgot Password</h4>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert-box">
                        {{ session('success') }}
                    </div>
                @endif
                <form id="resetPasswordForm" action="{{ route('doctor.forgot.action') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="Enter your email address">
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-blue w-100 mb-4">Submit</button>
                </form>
            </div>
        </div>
        <div class="right-col">
            <i class="fas fa-envelope fa-5x mb-4"></i>
         
            <p>Enter your email address below, and we'll send you a link to reset your password.</p>
        </div>
    </div>

    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
