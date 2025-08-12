<?php

namespace App\Contracts\Dao;

interface DepartmentDaoInterface
{
    public function getAll();
    public function getAllDepartment();
    public function createDepartment(array $data);
    public function findById($id);
    public function destroy($id);
    public function update($id, array $data);
    public function search($searchTerm);
}
