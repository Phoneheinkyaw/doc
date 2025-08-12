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
                                    Appointment List
                                </div>
                                <ul class="nav float-left">
                                    <li>
                                        <div class="top-nav-search">
                                            <a href="javascript:void(0);" class="responsive-search">
                                                <i class="fa fa-search"></i>
                                            </a>
                                            <form action="{{ route('list.appointment') }}" method="GET">
                                                <input class="form-control" type="text" name="search"
                                                    placeholder="Search Here" value="{{ request('search') }}">
                                                <button class="btn" type="submit"><i class="fa fa-search"></i></button>
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table custom-table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Patient</th>
                                        <th>Doctor</th>
                                        <th>Room</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
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
                                        @foreach ($appointments as $appointment)
                                            <tr>
                                                <td>{{ $appointment->id }}</td>
                                                <td>{{ $appointment->patient->name }}</td>
                                                <td>{{ $appointment->doctor->name }}</td>
                                                <td>{!! $appointment->room ? $appointment->room->name : '<span class="text-secondary">No Room Booked</span>' !!}</td>
                                                <td>{{ $appointment->appointment_date }}</td>
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
                                                <td>
                                                    <a href="{{ route('admin.appointment.view', $appointment->id) }}"
                                                        class="btn btn-info btn-sm mb-1">
                                                        <i class="far fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $appointments->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
