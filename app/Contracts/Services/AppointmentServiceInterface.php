<?php

namespace App\Contracts\Services;

interface AppointmentServiceInterface
{
    public function createAppointment($data);
    public function getAllAppointment($search, $doctorId);
    public function getAppointmentsByPatientId($patientID, $search);
    public function changeAppointmentStatus($appointmentId, $status);
    public function searchAppointment(string $keyword);
    public function updateIfPending($appointmentId, $status);
    public function updateIfConfirmed($appointmentId, $status);
    public function getMailByAppointment($appointmentId);
    public function getById($appointmentId);
    public function todayAppointments(int $doctorId);
    public function confirmedAppointments(int $doctorId);
    public function rejectedAppointments(int $doctorId);
    public function pendingAppointments(int $doctorId);
    public function finishedAppointments(int $doctorId);
    public function missedAppointments(int $doctorId);
    public function getNextAppointment($patientId);
    public function getAllAppointmentCount($patientId);
    public function getPreviousCompletedAppointments($patientId);
}
