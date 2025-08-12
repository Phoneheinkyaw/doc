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
                                    Patient List
                                </div>
                                <ul class="nav float-left">
                                    <li>
                                        <div class="top-nav-search">
                                            <a href="javascript:void(0);" class="responsive-search">
                                                <i class="fa fa-search"></i>
                                            </a>
                                            <form action="{{ route('list.patient') }}" method="GET">
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
                                    <a href="{{ route('export.patient') }}" class="btn btn-outline-success">
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
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table custom-table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Gender</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($patients) > 0)
                                        <?php $i = 1; ?>
                                        @foreach ($patients as $patient)
                                            <tr>
                                                <td>
                                                    {{ $patient->name }}
                                                </td>
                                                <td>{{ $patient->email }}</td>
                                                <td>{{ $patient->phone }}</td>
                                                <td>{{ Str::limit($patient->address, 15) }}</td>
                                                <td>
                                                    @if ($patient->gender !== null && isset(config('constants.genders')[$patient->gender]))
                                                        {{ config('constants.genders')[$patient->gender] }}
                                                    @else
                                                        Not specified
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.patient.view', $patient->id) }}"
                                                        class="btn btn-info btn-sm mb-1">
                                                        <i class="far fa-eye"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-sm mb-1"
                                                        onclick="event.preventDefault();
                                                    if(confirm('Are you sure you want to delete Dr. {{ $patient->name }}?')) {
                                                        document.getElementById('delete-form-{{ $patient->id }}').submit();
                                                    }">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                    <form id="delete-form-{{ $patient->id }}"
                                                        action="{{ route('destroy.patient', $patient->id) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center fw-bold">No Result Found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $patients->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
