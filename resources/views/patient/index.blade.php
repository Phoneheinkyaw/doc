@extends('patient.layout.dashboard')
@section('main-visual')
    @php
        use Illuminate\Support\Facades\Auth;
        $patient = Auth::guard('patients')->user();
    @endphp
    <div class="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-sm-6">
                                <div class="page-title">
                                    Hello {{ $patient->name }}
                                </div>
                            </div>
                            <div class="rounded-md flex items-center justify-between">
                                <div class="text-gray-800 font-medium">
                                    {{ \Carbon\Carbon::now()->format('F j, Y') }}
                                    <i class="fa fa-calendar ml-2"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3 px-2">
            <div class="col-lg-8 p-2">
                <div class="card h-100">
                    <div class="card-body">
                        <h4 class="mb-3">Completed Appointments</h4>
                        <table class="table custom-table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Doctor</th>
                                    <th>Room</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($completedAppointments as $appointment)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') }}
                                        </td>
                                        <td>Dr. {{ $appointment->doctor->name }}</td>
                                        <td>{!! $appointment->room ? $appointment->room->name : '<span class="text-secondary">No Room Booked</span>' !!}</td>
                                        <td class="text-success font-weight-bold text-capitalize">
                                            {{ array_keys(config('constants.statuses'))[$appointment->status - 1] }}
                                        </td>
                                        <td>
                                            <a href="{{ route('appointment.detail', ['id' => $appointment->id], $appointment->patient->id) }}"
                                                class="btn btn-info btn-sm mb-1">
                                                <i class="far fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No completed appointments available for
                                            display.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-4 mb-0">
                            {{ $completedAppointments->links() }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 p-2 d-flex flex-column">
                <div class="card mb-3 h-100">
                    <div class="card-body">
                        <h4 class="mb-4 mt-1">Next Appointment</h4>
                        @if ($nextAppointment)
                            <p class="mb-1">In
                                <span class="text-primary">
                                    @php
                                        $appointmentDate = \Carbon\Carbon::parse($nextAppointment->appointment_date);
                                        $today = \Carbon\Carbon::today();
                                        $diffInDays = $today->diffInDays($appointmentDate, false);
                                    @endphp

                                    @if ($diffInDays > 1)
                                        {{ $diffInDays }} days from today
                                    @elseif($diffInDays === 1)
                                        Tomorrow
                                    @elseif($diffInDays === 0)
                                        Today
                                    @endif
                                </span>
                            </p>
                            <p class="mb-1">On
                                <strong>{{ \Carbon\Carbon::parse($nextAppointment->appointment_date)->format('d/m/Y') }}</strong>
                            </p>
                            <p class="mb-1">Doctor: <span class="text-success">{{ $nextAppointment->doctor->name }}</span>
                            </p>
                            <p class="mb-1">Room:
                                @if ($nextAppointment->room_id)
                                    <span class="text-info">{{ $nextAppointment->room->name }}</span>
                                @else
                                    <span class="text-secondary">No Room Booked</span>
                                @endif
                            </p>
                        @else
                            <p>No upcoming appointment available.</p>
                        @endif
                    </div>
                </div>
                <div class="card mb-0 h-100">
                    <div class="card-body">
                        <h4 class="mb-4 mt-1">Total Appointments</h4>
                        <h3 class="text-primary">{{ $count }} </h3>
                        @if ($count)
                            <p class="text-muted">appointments made so far</p>
                        @else
                            <p class="text-muted">no appointments made. <a href="{{ route('appointment.create') }}">Make
                                    an appointment.</a></p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-4 p-3 border-top">
            <p><strong>Doctor Appointment Contact:</strong> +959 234234324 | +959 234234324 | <a
                    href="http://localhost:8000/">info@Doctor Appointment.com</a>
            </p>
            <p><small>Doctor Appointment, Mandalay, Chanmyathazi Township</small></p>
            <p class="text-muted"><small>"An ounce of prevention is worth a pound of cure. Regular check-ups and
                    proactive healthcare can make all the difference. Take care of your health before symptoms
                    appear."</small></p>

        </div>
    </div>
@endsection
