@extends('doctor.layout.dashboard')
@section('main-visual')
    <div class="page-wrapper">
        <div class="row justify-content-center">
            <div class="col-md-6 mx-auto mt-3 ">
                @if (session('error'))
                    <div class="alert alert-danger mt-3" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success mt-3" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="card shadow">
                    <div class="card-header text-center ">
                        <h3>Change Password</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('doctor.upload.psw') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="current_password" class="font-weight-bold">Current Password</label>
                                <input type="password" name="current_password" id="current_password" class="form-control"
                                    value="{{ old('current_password') }}">
                                @error('current_password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="new_password" class="font-weight-bold">New Password</label>
                                <input type="password" name="new_password" id="new_password" class="form-control">
                                @error('new_password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="new_password_confirmation" class="font-weight-bold">Confirm New Password</label>
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                    class="form-control">
                                @error('new_password_confirmation')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('doctor.profile') }}" class="btn btn-gray">Back</a>
                                <button type="submit" class="btn btn-primary">Change</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
