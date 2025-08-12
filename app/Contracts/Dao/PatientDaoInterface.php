<?php

namespace App\Contracts\Dao;

interface PatientDaoInterface
{
    public function createPatient(array $data);
    public function getAllPatient();
    public function destroy($id);
    public function patientListByDoctorId(int $doctorId, $search);
    public function appointmentRecordByPatientId($doctorId, $patientId);
    public function getPatientById($patientId);
    public function updatePatient($data);
    public function deletePatient($patientId);
    public function searchPatients(string $keyword);
    public function updatePassword($patient, $password);
    public function getById($patientId);
}
