@extends('admin.layout.dashboard')
@section('main-visual')
    <div class="page-wrapper mt-3">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-sm-6">
                                <div class="page-title">
                                    Doctor List
                                </div>
                                <ul class="nav float-left">
                                    <li>
                                        <div class="top-nav-search">
                                            <a href="javascript:void(0);" class="responsive-search">
                                                <i class="fa fa-search"></i>
                                            </a>
                                            <form action="{{ route('list.doctor') }}" method="GET">
                                                <input class="form-control" type="text" name="search"
                                                    placeholder="Search Here" value="{{ request('search') }}">
                                                <button class="btn" type="submit"><i class="fa fa-search"></i></button>
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-sm-6 text-sm-right">
                                <div class="mt-sm-0 mt-2">
                                    <a href="{{ route('create.doctor') }}" class="btn btn-outline-success mr-2">
                                        <i class="fas fa-plus"></i>
                                        <span class="ml-2">Create</span></a>
                                    <a href="{{ route('export.doctor') }}" class="btn btn-outline-success mr-2">
                                        <i class="fas fa-file"></i>
                                        <span class="ml-2">Export</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table custom-table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Profile</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Department</th>
                                        <th>Licence</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($doctors->isEmpty())
                                        <tr>
                                            <td colspan="7" class="text-center fw-bold">
                                                No Result Found
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($doctors as $doctor)
                                            <tr>
                                                <td>
                                                    @if ($doctor->image)
                                                        <img src="{{ asset('storage/' . $doctor->image) }}"
                                                            alt="profile-img" class="img-circle-sm">
                                                    @else
                                                        <img src="{{ asset('img/profile/profile.png')}}"
                                                            alt="profile-img" class="img-circle-sm">
                                                    @endif
                                                </td>
                                                <td>{{ $doctor->name }}</td>
                                                <td>{{ $doctor->email }}</td>
                                                <td>{{ $doctor->phone }}</td>
                                                <td>{{ $doctor->department->name }}</td>
                                                <td>{{ $doctor->licence_number }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.doctor.view', $doctor->id) }}"
                                                        class="btn btn-info btn-sm mb-1">
                                                        <i class="far fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('edit.doctor', $doctor->id) }}"
                                                        class="btn btn-primary btn-sm mb-1">
                                                        <i class="far fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-sm mb-1"
                                                        onclick="event.preventDefault();
                                                if(confirm('Are you sure you want to delete Dr. {{ $doctor->name }}?')) {
                                                    document.getElementById('delete-form-{{ $doctor->id }}').submit();
                                                }">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                    <form id="delete-form-{{ $doctor->id }}"
                                                        action="{{ route('destroy.doctor', $doctor->id) }}" method="POST"
                                                        style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $doctors->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
