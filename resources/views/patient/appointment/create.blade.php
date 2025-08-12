@extends('patient.layout.dashboard')
@section('main-visual')
    <div class="page-wrapper">
        <div class="row">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header w-100 d-flex justify-content-between align-items-center">
                        <h2>Appointment</h2>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="pl-0 mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li class="list-unstyled py-1">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session('success') || session('createError'))
                            <div class="alert {{ session('success') ? 'alert-success' : 'alert-danger' }}">
                                {{ session('success') ?? session('createError') }}
                            </div>
                        @endif


                        <form action="{{ route('appointment.store') }}" method="POST">
                            @auth('patients')
                                <h4 class="my-3">Patient Id: <span
                                        class="text-success">{{ Auth::guard('patients')->id() ?? 'Log In First!!!!!!' }}</span>
                                </h4>
                                <h4 class="my-3">Patient Name: <span
                                        class="text-success">{{ Auth::guard('patients')->getUser()->name ?? 'Log In Ba' }}</span>
                                </h4>
                                <h4 class="my-3">Gender: <span
                                        class="text-success">{{ config('constants.genders')[Auth::guard('patients')->getUser()->gender] ?? 'Log In Ba' }}</span>
                                </h4>
                                <input type="text" id="patientId" name="patientId" hidden
                                    value="{{ Auth::guard('patients')->id() }}">
                            @else
                                <p>Please log in to make an appointment.</p>
                            @endauth
                            <input type="text" id="patientId" name="patientId" hidden
                                value="{{ Auth::guard('patients')->id() }}">
                            @csrf
                            <div class="mb-3 mt-5">
                                <label class="label font-weight-bold" for="name">Appointment Date</label>
                                <input type="date" class="form-control col-lg-3" id="date" name="date"
                                    value="{{ old('date') }}">
                            </div>
                            <div class="row mb-3">
                                <div class="col-6 col-lg-4">
                                    <label class="label font-weight-bold" for="department">Select your hospital
                                        department</label>
                                    <select class="form-control  " id="department" name="department">
                                        <option value="">Select Department</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}"
                                                {{ old('department') == $department->id ? 'selected' : '' }}>
                                                {{ $department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6 col-lg-4">
                                    <label class="label font-weight-bold" for="doctor">Select appointment doctor</label>
                                    <select disabled class="form-control " data-old-value="{{ old('doctor') }}"
                                        id="doctor" name="doctor">
                                        <option value="">Select Doctor</option>
                                        @if (old('doctor'))
                                            <option value="">
                                                {{ old('doctor') }}
                                            </option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="label font-weight-bold">Book a hospital room?</label><br>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="room_yes" name="room"
                                        value="1" {{ old('room') == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="room_yes">Yes</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="room_no" name="room"
                                        value="0" {{ old('room') == '1' ? '' : 'checked' }}>
                                    <label class="form-check-label" for="room_no">No</label>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('patient.get-all-appointment', ['patientId' => Auth::user()->id]) }}"
                                    class="btn btn-gray mb-4">
                                    Back
                                </a>
                                <button type="submit" class="btn btn-primary px-5 mb-4">Make An Appointment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
