<?php

namespace App\Services;

use App\Contracts\Dao\AppointmentDaoInterface;
use App\Contracts\Dao\RoomDaoInterface;
use App\Contracts\Services\AppointmentServiceInterface;
use App\Models\Appointment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class AppointmentService implements AppointmentServiceInterface
{
    protected AppointmentDaoInterface $appointmentDao;
    protected RoomDaoInterface $roomDao;

    /**
     * @param AppointmentDaoInterface $appointmentDao
     * @param RoomDaoInterface $roomDao
     */
    public function __construct(AppointmentDaoInterface $appointmentDao, RoomDaoInterface $roomDao)
    {
        $this->appointmentDao = $appointmentDao;
        $this->roomDao = $roomDao;
    }

    /**
     * create a new appointment
     * @param $data
     * @return void
     */
    public function createAppointment($data): void
    {
        $preparedData = $this->prepareAppointmentData($data);
        $this->appointmentDao->createAppointment($preparedData);
        if ($preparedData['room_id']) {
            $this->roomDao->changeRoomStatus($preparedData['room_id']);
        }
    }

    /**
     * Prepare data before passing to query
     * @param $data
     * @return array
     */
    protected function prepareAppointmentData($data): array
    {
        $roomId = null;
        if ($data['room']) {
            $room = $this->roomDao->getFirstAvailableRoom();
            $roomId = (string)$room->id;
        }
        return [
            'appointment_date' => $data['date'],
            'patient_id' => $data['patientId'],
            'doctor_id' => $data['doctor'],
            'room_id' => $data['room'] == 1 ? $roomId : null,
        ];
    }

    /**
     * Get all appointments
     * @param $search
     * @param $doctorId
     * @return LengthAwarePaginator
     */
    public function getAllAppointment($search, $doctorId): LengthAwarePaginator
    {
        return $this->appointmentDao->getAllAppointment($search, $doctorId);
    }

    /**
     * get appointment by patient id
     * @param $patientID
     * @return LengthAwarePaginator
     */
    public function getAppointmentsByPatientId($patientID, $search): LengthAwarePaginator
    {
        return $this->appointmentDao->getAppointmentsByPatientId($patientID, $search);
    }

    /**
     * confirm Appointment /Reject function /It allow for pending status
     * @param int $appointmentId
     * @param string $status
     * @return boolean
     */
    public function updateIfPending($appointmentId, $status)
    {
        $currentStatus = $this->appointmentDao->getAppointmentStatus($appointmentId);
        if ($currentStatus === config('constants.statuses.pending')) {
            return $this->appointmentDao->changeAppointmentStatus($appointmentId, $status);
        }
        return false;
    }

    /**
     * Change the appointment status
     * @param $appointmentId
     * @param $status
     * @return void
     */
    public function changeAppointmentStatus($appointmentId, $status): void
    {
        $this->appointmentDao->changeAppointmentStatus($appointmentId, $status);
    }

    /**
     * update if confirmed
     * @param int $appointmentId
     * @param int $status
     * @return boolean
     */
    public function updateIfConfirmed($appointmentId, $status)
    {
        $currentStatus = $this->appointmentDao->getAppointmentStatus($appointmentId);
        if ($currentStatus === config('constants.statuses.confirmed')) {
            return $this->appointmentDao->changeAppointmentStatus($appointmentId, $status);
            return null;
        }
        return false;
    }

    /**
     * search appointments
     * @param string $keyword
     */
    public function searchAppointment(string $keyword)
    {
        return $this->appointmentDao->searchAppointment($keyword);
    }

    /**
     * get patient's mail address from appointment id
     * @param int $appointmentId
     */
    public function getMailByAppointment($appointmentId)
    {
        return $this->appointmentDao->getMailByAppointment($appointmentId);
    }

    /**
     * get appointment by id
     * @param int $appointmentId
     * @return Appointment
     */
    public function getById($appointmentId): Appointment
    {
        return $this->appointmentDao->getById($appointmentId);
    }

    /**
     * Count today's appointments for a specific doctor.
     * @param integer $doctorId
     * @return Collection
     */
    public function todayAppointments(int $doctorId): Collection
    {
        return $this->appointmentDao->todayAppointments($doctorId);
    }

    /**
     * Get confirmed appointments for a specific doctor.
     * @param integer $doctorId
     * @return Collection
     */
    public function confirmedAppointments(int $doctorId): Collection
    {
        return $this->appointmentDao->confirmedAppointments($doctorId);
    }

    /**
     * Get rejected appointments for a specific doctor.
     * @param integer $doctorId
     * @return Collection
     */
    public function rejectedAppointments(int $doctorId): Collection
    {
        return $this->appointmentDao->rejectedAppointments($doctorId);
    }

    /**
     * Get pending appointments for a specific doctor.
     * @param integer $doctorId
     * @return Collection
     */
    public function pendingAppointments(int $doctorId): Collection
    {
        return $this->appointmentDao->pendingAppointments($doctorId);
    }

    /**
     * Get finished appointments for a specific doctor.
     * @param integer $doctorId
     * @return Collection
     */
    public function finishedAppointments(int $doctorId): Collection
    {
        return $this->appointmentDao->finishedAppointments($doctorId);
    }

    /**
     * Get missed appointments for a specific doctor.
     * @param integer $doctorId
     * @return Collection
     */
    public function missedAppointments(int $doctorId): Collection
    {
        return $this->appointmentDao->missedAppointments($doctorId);
    }

    /**
     * Get next appointment
     * @param $patientId
     * @return Appointment|null
     */
    public function getNextAppointment($patientId): Appointment|null
    {
        return $this->appointmentDao->getNextAppointment($patientId);
    }

    /**
     * Get all the patient's appointment count
     * @param $patientId
     * @return int
     */
    public function getAllAppointmentCount($patientId): int
    {
        return $this->appointmentDao->getAllAppointmentCount($patientId);
    }

    /**
     * get previously completed appointments for patient
     * @param $patientId
     * @return LengthAwarePaginator
     */
    public function getPreviousCompletedAppointments($patientId): LengthAwarePaginator
    {
        return $this->appointmentDao->getPreviousCompletedAppointments($patientId);
    }
}
