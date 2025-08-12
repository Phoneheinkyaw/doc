@extends('patient.layout.dashboard')
@section('main-visual')
    <div class="page-wrapper">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-sm-6">
                                <div class="page-title">
                                    Appointment List
                                </div>
                            </div>
                            <div class="col-sm-6 text-sm-right">
                                <div class="mt-sm-0 mt-2">
                                    <a href="{{ route('appointment.create') }}" class="btn btn-primary">Make an
                                        appointment</a>
                                </div>
                            </div>
                        </div>
                        <ul class="nav float-left">
                            <li>
                                <div class="top-nav-search">
                                    <form
                                        action="{{ route('patient.get-all-appointment', ['patientId' => Auth::guard('patients')->user()->id]) }}"
                                        method="GET">
                                        <input class="form-control" name="search" type="text" placeholder="Search here"
                                            value="{{ request('search') }}">
                                        <button class="btn" type="submit"><i class="fa fa-search"></i></button>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <!-- Display Success Message -->
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
                        @if ($errors->any())
                            <div class="alert alert-danger error-scroll">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table custom-table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Doctor Name</th>
                                        <th>Appointment Date</th>
                                        <th>Room</th>
                                        <th>Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($appointments as $appointment)
                                        <tr>
                                            <td>{{ $appointment->id }}</td>
                                            <td>{{ $appointment->doctor->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') }}
                                            <td>{!! $appointment->room ? $appointment->room->name : '<span class="text-secondary">No Room Booked</span>' !!}</td>

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
                                            <td class="text-center">
                                                <div class="d-flex align-items-stretch justify-content-center">
                                                    @if ($appointment->status === config('constants.statuses.pending'))
                                                        <form action="{{ route('patient.cancel-appointment') }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            <input type="hidden" name="appointmentId" id="appointmentId"
                                                                value="{{ $appointment->id }}">
                                                            <input type="hidden" name="roomId" id="roomId"
                                                                value="{{ $appointment->room_id }}">
                                                            <input type="hidden" name="status" id="status"
                                                                value="{{ config('constants.statuses.canceled') }}">
                                                            <button type="submit"
                                                                class="btn btn-danger btn-sm mr-1 action-button"
                                                                onclick="return confirm('Are you sure you want to cancel this appointment? This action is irreversible.')">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    <a href="{{ route('appointment.detail', ['id' => $appointment->id]) }}"
                                                        class="btn btn-info btn-sm mb-1">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="12" class="text-center">No Result Found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="mt-4">
                                    {{ $appointments->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
