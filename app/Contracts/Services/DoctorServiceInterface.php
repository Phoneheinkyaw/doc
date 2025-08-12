<?php

namespace App\Contracts\Services;

interface DoctorServiceInterface
{
    public function getAll();
    public function create(array $data);
    public function destroy($id);
    public function getDoctorById($id);
    public function getDoctorByEmail($email);
    public function updateDoctor($id, array $data);
    public function uploadProfileImage(array $data);
    public function changePassword($doctor, $newPassword);
    public function resetDoctorPassword($doctor, $newPassword);
    public function getDocFromDepartmentId($departmentId);
    public function searchDoctors(string $keyword);
    public function getLatestDoctor();
    public function hasAppointments($doctorId);
}
