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
                                    Appointment List
                                </div>
                                <ul class="nav float-left">
                                    <li>
                                        <div class="top-nav-search">
                                            <a href="javascript:void(0);" class="responsive-search">
                                                <i class="fa fa-search"></i>
                                            </a>
                                            <form action="{{ route('doctor.appointment.list') }}" method="GET">
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
                                    <a href="{{ route('admin.appointment.export') }}" class="btn btn-outline-success mr-2">
                                        <i class="fas fa-file"></i><span class="ml-2">Export</span>
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
                                        <th>Appointment Date</th>
                                        <th>Room Name</th>
                                        <th>View</th>
                                        <th>Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($appointments->isEmpty())
                                        <tr>
                                            <td colspan="7" class="text-center fw-bold">
                                                No Result Found
                                            </td>
                                        </tr>
                                    @else
                                        @php
                                            $offset = ($appointments->currentPage() - 1) * $appointments->perPage();
                                        @endphp
                                        @foreach ($appointments as $appointment)
                                            <tr>
                                                <td>{{ $offset + $loop->iteration }}</td>
                                                <td>{{ $appointment->patient->name }}</td>
                                                <td>{{ date('d M Y', strtotime($appointment->appointment_date)) }}</td>
                                                <td>{!! $appointment->room ? $appointment->room->name : '<span class="text-secondary">No Room Booked</span>' !!}</td>
                                                <td>
                                                    <a href="{{ route('doctor.appointment.view', $appointment->id) }}"
                                                        class="btn btn-info btn-sm mb-1">
                                                        <i class="far fa-eye"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    @switch($appointment->status)
                                                        @case(1)
                                                            <p class="text-info font-weight-bold"> Pending</p>
                                                        @break
                                                        @case(2)
                                                            <p class="text-danger font-weight-bold"> Rejected</p>
                                                        @break
                                                        @case(3)
                                                            <p class="text-warning font-weight-bold"> Confirmed</p>
                                                        @break
                                                        @case(4)
                                                            <p class="text-dark font-weight-bold"> Missed</p>
                                                        @break
                                                        @case(5)
                                                            <p class="text-success font-weight-bold"> Finished</p>
                                                        @break
                                                        @case(6)
                                                            <p class="text-danger font-weight-bold"> Canceled</p>
                                                        @break
                                                    @endswitch
                                                </td>
                                                <td class="text-right">
                                                    <form
                                                        action="{{ route('doctor.appointment.reject', $appointment->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @method('PUT')
                                                        @csrf
                                                        <input type="hidden" name="status"
                                                            value="{{ config('constants.statuses.rejected') }}">
                                                        <button type="submit"
                                                            class="btn btn-danger btn-sm mb-1 action-button">Reject</button>
                                                    </form>
                                                    <form
                                                        action="{{ route('doctor.appointment.confirm', $appointment->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status"
                                                            value="{{ config('constants.statuses.confirmed') }}">
                                                        <button type="submit"
                                                            class="btn btn-info btn-sm mb-1 action-button">Confirm</button>
                                                    </form>
                                                    <form
                                                        action="{{ route('doctor.appointment.complete', $appointment->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status"
                                                            value="{{ config('constants.statuses.finished') }}">
                                                        <button type="submit"
                                                            class="btn btn-success btn-sm mb-1 action-button">Finished</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4 d-flex justify-content-center">
                            {{ $appointments->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
