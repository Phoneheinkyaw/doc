<?php

namespace App\Contracts\Dao;

interface DoctorDaoInterface
{
    public function getAll();
    public function create(array $data);
    public function destroy($id);
    public function getDoctorById($id);
    public function findByEmail($email);
    public function updateDoctor($id, array $data);
    public function uploadProfileImage($doctor);
    public function updatePassword($doctor, $newPassword);
    public function getDocFromDepartmentId($departmentId);
    public function searchDoctors(string $keyword);
    public function getLatestDoctor();
    public function hasAppointments($doctorId);
}
