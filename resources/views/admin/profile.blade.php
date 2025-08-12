@extends('admin.layout.dashboard')
@section('main-visual')
<div class="page-wrapper">
    <div class="container my-5">
        <div class="profile_success">
            <div id="success_message"></div>
        </div>
        <div class="row justify-content-center">
            <!-- Profile Card Preview -->
            <div class="col-md-6 mt-5">
                <!-- Success Message -->
                <div class="card profile-card p-4 shadow-sm position-relative">
                    <div class="d-flex justify-content-center mb-3 position-relative">
                        <img id="profileImagePreview"
                            src="{{ Auth::guard('admins')->user()->image ? asset('storage/' . Auth::guard('admin')->user()->image) : asset('img/profile/profile.png') }}"
                            alt="Profile Picture" class="rounded-circle" width="120" height="120">

                    </div>

                    <!-- Profile Information -->
                    <div class="ml-5">
                        <div class="ml-3 d-flex align-items-center mb-3">
                            <p class="font-weight-bold mb-0 mr-2">Name:</p>
                            <h5 id="profileNamePreview" class="mb-0">
                                {{ Auth::guard('admins')->user()->name ?? 'User Name' }}</h5>
                        </div>

                        <div class="ml-3 d-flex align-items-center mb-3">
                            <p class="font-weight-bold mb-0 mr-2">Email:</p>
                            <p id="profileEmailPreview" class="mb-0 text-muted">
                                {{ Auth::guard('admins')->user()->email ?? 'your-email@example.com' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
