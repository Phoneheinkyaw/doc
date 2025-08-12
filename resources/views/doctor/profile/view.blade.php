@extends('doctor.layout.dashboard')
@section('main-visual')
<div class="page-wrapper">
    <div class="container my-5">
        <div class="profile_success">
        <div id="success_message">
            <div id="success_message">
                     @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
        </div>
    </div>
        <div class="row justify-content-center">
            <!-- Profile Card Preview -->
            <div class="col-md-6 mt-5">
                <!-- Success Message -->
                <div class="card profile-card p-4 shadow-sm position-relative">
                    <div class="d-flex justify-content-center mb-3 position-relative">
                        <img id="profileImagePreview"
                            src="{{ Auth::guard('doctors')->user()->image ? asset('storage/' . Auth::guard('doctors')->user()->image) : asset('img/profile/profile.png') }}"
                            alt="Profile Picture" class="rounded-circle" width="120" height="120">
                        <a href="#" class="btn btn-primary position-absolute"
                            style="top: 70%; left: 60%; font-size: 0.6rem;" id="editProfileButton">
                            upload
                        </a>
                    </div>
                    <!-- Profile Information -->
                    <div class="ml-5">
                        <div class="ml-3 d-flex align-items-center mb-3">
                            <p class="font-weight-bold mb-0 mr-2">Name:</p>
                            <h5 id="profileNamePreview" class="mb-0">
                                {{ Auth::guard('doctors')->user()->name ?? 'User Name' }}</h5>
                        </div>

                        <div class="ml-3 d-flex align-items-center mb-3">
                            <p class="font-weight-bold mb-0 mr-2">Email:</p>
                            <p id="profileEmailPreview" class="mb-0 text-muted">
                                {{ Auth::guard('doctors')->user()->email ?? 'your-email@example.com' }}</p>
                        </div>

                        <div class="ml-3 d-flex align-items-center mb-3">
                            <p class="font-weight-bold mb-0 mr-2">Phone:</p>
                            <p class="mb-0 text-muted">{{ Auth::guard('doctors')->user()->phone ?? '09-885672201' }}</p>
                        </div>

                        <div class="ml-3 d-flex align-items-center mb-3">
                            <p class="font-weight-bold mb-0 mr-2">Department:</p>
                            <p class="mb-0 text-muted">
                                {{ Auth::guard('doctors')->user()->department->name ?? 'Department Name' }}</p>
                        </div>
                         <div class="ml-3 d-flex align-items-center mb-3 justify-content-between">

                                <a href="{{ route('doctor.change.psw') }}"
                                    class="btn btn-success  text-sm  px-2 py-1">
                                    Change Password</a>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal for Editing Profile Image -->
<div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">
                    <i class="fas fa-user-edit"></i> Edit Profile Image
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="profileImageForm" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group ">
                        <label for="profileImage" class="font-weight-bold col-md-4">Upload New Image</label>
                        <label for="profileImage" class="btn btn-outline-info col-md-4 btn-sm">
                            <i class="fas fa-upload"></i> Choose File
                        </label>
                        <input type="file" id="profileImage" name="image" class="custom-file-input" style="display: none;">
                        <small id="fileError" class="form-text text-danger"></small>
                    </div>
                    <div class="form-group text-center">
                        <img id="newProfileImagePreview" src="" alt="New Profile Preview"
                            class="rounded-circle border" width="100" height="100" style="display:none;">
                    </div>
                    <button type="submit" class="btn btn-success float-right">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
