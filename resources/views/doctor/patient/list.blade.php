@extends('doctor.layout.dashboard')
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
                                            <form action="{{ route('doctor.patient.list') }}" method="GET">
                                                <input class="form-control" name="search" type="text"
                                                    placeholder="Search here" value="{{ request('search') }}">
                                                <button class="btn" type="submit"><i class="fa fa-search"></i></button>
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-sm-6 text-sm-right">
                                <div class="mt-sm-0 mt-2">
                                    <a href="{{ route('doctor.patient.list.export') }}"
                                        class="btn btn-outline-success mr-2">
                                        <i class="fas fa-file"></i>
                                        <span class="ml-2">Export</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
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
                                        <th>ID</th>
                                        <th>Patient Name</th>
                                        <th>Total Appointments</th>
                                        <th>View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($patients->isEmpty())
                                        <tr>
                                            <td colspan="4" class="text-center fw-bold">
                                                No Result Found
                                            </td>
                                        </tr>
                                    @else
                                        @php
                                            $offset = ($patients->currentPage() - 1) * $patients->perPage();
                                        @endphp
                                        @foreach ($patients as $patient)
                                            <tr>
                                                <td>{{ $offset + $loop->iteration }}</td>
                                                <td>{{ $patient->name }}</td>
                                                <td>{{ $patient->total_appointments }}</td>
                                                <td>
                                                    <a href="{{ route('doctor.patient.appointment.record', $patient->patient_id) }}"
                                                        class="btn btn-info btn-sm mb-1">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4 d-flex justify-content-center">
                            {{ $patients->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
