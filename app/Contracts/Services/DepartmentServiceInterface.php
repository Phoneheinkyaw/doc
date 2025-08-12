<?php

namespace App\Contracts\Services;

interface DepartmentServiceInterface
{
    public function getAll();
    public function getAllDepartment();
    public function storeDepartment(array $data);
    public function getDepartmentById($id);
    public function updateDepartment($id, array $data);
    public function destroy($id);
    public function search($searchTerm);
}
