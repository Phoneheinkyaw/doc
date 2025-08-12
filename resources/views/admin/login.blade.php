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
    <link rel="stylesheet" href="{{ asset('admin/css/style.css')}}">
</head>

<body>
    <div class="container">
        <div class="left-col">
            <h4 class="text-center">Admin Login</h4>
            <form method="POST" action="{{ route('admin.authenticate') }}">
                @csrf
                <div class="form-group mb-3">
                    <label for="email">Email Address</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                        name="email" value="{{ old('email') }}">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="password">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                        name="password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <a href="{{ route("welcome") }}" class="color-white">Home</a>
                    <button type="submit" class="btn btn-blue">Login</button>
                </div>
            </form>
        </div>
        <div class="right-col">
            <i class="fas fa-hospital fa-5x mb-4"></i>
            
            <p class="text-center">Access your administrative tools, manage patient records, and oversee hospital
                operations securely.</p>
        </div>
    </div>
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
