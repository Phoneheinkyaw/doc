@extends('admin.layout.dashboard')
@section('main-visual')
    <div class="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Doctor Edit</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('update.doctor', $doctor->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT') <!-- Add this to make it a PUT request -->
                            <div class="form-group">
                                <label for="name" class="font-weight-bold">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $doctor->name) }}">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email" class="font-weight-bold">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email', $doctor->email) }}">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="phone" class="font-weight-bold">Phone</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" value="{{ old('phone', $doctor->phone) }}">
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="department_id" class="font-weight-bold">Department</label>
                                <select class="form-control @error('department_id') is-invalid @enderror" id="department_id"
                                    name="department_id">
                                    <option value="">Select Department</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}"
                                            {{ old('department_id', $doctor->department_id) == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}</option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="licence_number" class="font-weight-bold">Licence Number</label>
                                <input type="text" class="form-control @error('licence_number') is-invalid @enderror"
                                    id="licence_number" name="licence_number"
                                    value="{{ old('licence_number', $doctor->licence_number) }}">
                                @error('licence_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="image" class="font-weight-bold">Image</label>
                                <input type="file" class="form-control-file @error('image') is-invalid @enderror"
                                    id="image" name="image">
                                @if ($doctor->image)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $doctor->image) }}" alt="{{ $doctor->name }}"
                                            height="100">
                                    </div>
                                @endif
                                @error('image')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('list.doctor') }}" class="btn btn-gray">Back</a>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
