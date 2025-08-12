<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="https://laravel.com/img/favicon/favicon-16x16.png" type="image/x-icon">
    <title>Dashboard</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('doctor/css/style.css') }}">
</head>

<body>
    <div class="container">
        <div class="left-col">
            <h4 class="text-center">Reset Password</h4>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert-box">
                        {{ session('success') }}
                    </div>
                @endif
                <form id="newPasswordForm" action="{{ route('doctor.restore.password') }}" method="post">
                    @csrf
                    <input type="hidden" name="email" value="{{ request()->query('name') }}">
                    <div class="form-group">
                        <input type="hidden" class="form-control font-dark" id="email"
                            value="{{ request()->query('name') }}">
                    </div>
                    <div class="form-group">
                        <label for="newPassword">New Password</label>
                        <input type="password" class="form-control" id="newPassword" name="newPassword">
                        @error('newPassword')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Confirm Password</label>
                        <input type="password" class="form-control" id="confirmPassword"
                            name="newPassword_confirmation">
                        @error('newPassword_confirmation')
                            <small class="text-danger">{{ $message }}</small>
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
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
