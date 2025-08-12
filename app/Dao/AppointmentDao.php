<?php

namespace App\Dao;

use App\Contracts\Dao\AppointmentDaoInterface;
use App\Models\Appointment;
use App\Models\Patient;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class AppointmentDao implements AppointmentDaoInterface
{
    /**
     * create new appointment
     * @param $data
     * @return void
     * @throws Exception
     */
    public function createAppointment($data): void
    {
        $existingAppointment = Appointment::where('patient_id', $data['patient_id'])
            ->whereDate('appointment_date', $data['appointment_date'])
            ->first();

        if ($existingAppointment) {
            throw new \Exception("You have already made an appointment for that day.");
        }
        Appointment::create($data);
    }

    /**
     * get all appointments
     * @param $search
     * @param $doctorId
     * @return LengthAwarePaginator
     */

    public function getAllAppointment($search, $doctorId): LengthAwarePaginator
    {
        return Appointment::with(['patient', 'room'])
            ->where('status', '!=', config('constants.statuses.canceled'))
            ->where('doctor_id', $doctorId)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('appointment_date', 'like', '%' . $search . '%')
                        ->orWhereHas('patient', function ($query) use ($search) {
                            $query->where('name', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('room', function ($query) use ($search) {
                            $query->where('name', 'like', '%' . $search . '%');
                        });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(7)
            ->appends(['search' => $search]);
    }

    /**
     * Get appoints from patient's id
     * @param $patientId
     * @return LengthAwarePaginator
     */
    public function getAppointmentsByPatientId($patientId, $search = null): LengthAwarePaginator
    {
        if (!is_numeric($patientId)) {
            throw new ModelNotFoundException();
        }
        Patient::findOrFail($patientId);

        $appointments  = Appointment::where('patient_id', $patientId)
            ->orderBy('appointment_date', 'asc');

        if ($search) {
            $appointments->whereHas('doctor', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        }
        return $appointments->paginate(7)->appends(['search' => $search]);
    }


    /**
     * change the status of the appointment
     * @param $appointmentId
     * @param $status
     * @return void
     * @throws Exception
     */
    public function changeAppointmentStatus($appointmentId, $status): void
    {
        $appointment = Appointment::findOrFail($appointmentId);
        $appointment->status = $status;
        $appointment->save();
        if (!$appointment->save()) {
            throw new Exception("Failed to update appointment status.");
        }
    }

    /**
     * get appointment's status
     * @param int $appointmentId
     * @throws Exception
     */
    public function getAppointmentStatus($appointmentId)
    {
        $status = Appointment::where('id', $appointmentId)->value('status');
        if (is_null($status)) {
            throw new Exception("Failed to retrieve appointment status.");
        }
        return $status;
    }

    /**
     * Search appointments
     * @param string $keyword
     * @return LengthAwarePaginator
     */
    public function searchAppointment(string $keyword): LengthAwarePaginator
    {
        $status = config('constants.statuses');
        $searchLower = strtolower(trim($keyword));

        $query = Appointment::with(['patient', 'doctor', 'room'])
            ->where(function ($query) use ($keyword, $searchLower, $status) {
                $query->whereHas('patient', function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                })
                    ->orWhereHas('doctor', function ($query) use ($keyword) {
                        $query->where('name', 'like', '%' . $keyword . '%');
                    })
                    ->orWhereHas('room', function ($query) use ($keyword) {
                        $query->where('name', 'like', '%' . $keyword . '%');
                    })
                    ->orWhere('appointment_date', 'like', '%' . $keyword . '%')
                    ->orWhere(function ($query) use ($searchLower, $status) {
                        foreach ($status as $statusName => $statusValue) {
                            if (strpos($statusName, $searchLower) !== false) {
                                $query->orWhere('status', $statusValue);
                            }
                        }
                        if (is_numeric($searchLower) && in_array((int)$searchLower, $status)) {
                            $query->orWhere('status', (int)$searchLower);
                        }
                    });
            });

        return $query->paginate(10)->appends(['search' => $keyword]);
    }

    /**
     * get patient's mail address
     * @param int $appointmentId
     * @return null or string
     */
    public function getMailByAppointment($appointmentId)
    {
        $appointment = Appointment::with('patient')->find($appointmentId);
        if ($appointment && $appointment->patient) {
            return $appointment->patient->email;
        }
        return null;
    }

    /**
     * get appointment by id
     * @param int $appointmentId
     * @return Appointment
     */
    public function getById($appointmentId): Appointment
    {
        $appointment = Appointment::where('id', $appointmentId)->first();
        if (is_null($appointment)) {
            abort(404, "Appointment not found with ID: $appointmentId.");
        }
        return $appointment;
    }

    /**
     * Count today's appointments for a specific doctor.
     * @param int $doctorId
     * @return Collection
     */
    public function todayAppointments(int $doctorId): Collection
    {
        return Appointment::where('doctor_id', $doctorId)
            ->whereBetween('appointment_date', [
                now()->startOfDay(),
                now()->endOfDay(),
            ])
            ->where('status', config('constants.statuses.confirmed'))
            ->orderBy('appointment_date', 'asc')
            ->get();
    }

    /**
     * Get confirmed appointments for a specific doctor.
     * @param int $doctorId
     * @return Collection
     */
    public function confirmedAppointments(int $doctorId): Collection
    {
        return Appointment::where('doctor_id', $doctorId)
            ->where('status', config('constants.statuses.confirmed'))
            ->orderBy('appointment_date', 'asc')
            ->get();
    }

    /**
     * Get rejected appointments for a specific doctor.
     * @param int $doctorId
     * @return Collection
     */
    public function rejectedAppointments(int $doctorId): Collection
    {
        return Appointment::where('doctor_id', $doctorId)
            ->where('status', config('constants.statuses.rejected'))
            ->orderBy('appointment_date', 'asc')
            ->get();
    }

    /**
     * Get pending appointments for a specific doctor.
     * @param int $doctorId
     * @return LengthAwarePaginator
     */
    public function pendingAppointments(int $doctorId): Collection
    {
        return Appointment::where('doctor_id', $doctorId)
            ->where('status', config('constants.statuses.pending'))
            ->orderBy('appointment_date', 'asc')
            ->get();
    }

    /**
     * Get finished appointments for a specific doctor.
     * @param int $doctorId
     * @return Collection
     */
    public function finishedAppointments(int $doctorId): Collection
    {
        return Appointment::where('doctor_id', $doctorId)
            ->where('status', config('constants.statuses.finished'))
            ->get();
    }

    /**
     * Get missed appointments for a specific doctor.
     * @param integer $doctorId
     * @return collection
     */
    public function missedAppointments(int $doctorId): Collection
    {
        return Appointment::where('doctor_id', $doctorId)
            ->where('status', config('constants.statuses.missed'))
            ->get();
    }

    /**
     * Get next appointment for patient
     * @param $patientId
     * @return Appointment|null
     */
    public function getNextAppointment($patientId): Appointment|null
    {
        return Appointment::where('patient_id', $patientId)
            ->where('appointment_date', '>=', Carbon::today())
            ->where('status', config('constants.statuses.confirmed'))
            ->orderBy('appointment_date', 'asc')
            ->first();
    }

    /**
     * Get all the patient's appointment count
     * @param $patientId
     * @return int
     */
    public function getAllAppointmentCount($patientId): int
    {
        return Appointment::where('patient_id', $patientId)->count();
    }

    /**
     * get previously completed appointments for patient
     * @param $patientId
     * @return LengthAwarePaginator
     */
    public function getPreviousCompletedAppointments($patientId): LengthAwarePaginator
    {
        return Appointment::where('patient_id', $patientId)
            ->where('status', config('constants.statuses.finished'))
            ->where('appointment_date', '<', Carbon::now())
            ->orderBy('appointment_date', 'desc')
            ->paginate(5);
    }
}
