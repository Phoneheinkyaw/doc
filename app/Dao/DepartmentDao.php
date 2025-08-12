<?php

namespace App\Dao;

use App\Contracts\Dao\DepartmentDaoInterface;
use App\Models\Department;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class DepartmentDao implements DepartmentDaoInterface
{
    /**
     * Retrieve all departments with pagination.
     * @return LengthAwarePaginator
     */
    public function getAll(): LengthAwarePaginator
    {
        return Department::paginate(10);
    }

    /**
     * create new department
     * @param array $data
     * @return Department
     */
    public function createDepartment(array $data): Department
    {
        return Department::create($data);
    }

    /**
     * Retrieve a department by their ID.
     * @param int $id
     * @return Department
     */
    public function findById($id): Department
    {
        return Department::findOrFail($id);
    }

    /**
     * Delete a department by their ID.
     * @param int $id
     * @return bool
     */
    public function destroy($id): bool
    {
        $department = Department::findOrFail($id);
        return $department->delete();
    }

    /**
     * Update the department information.
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update($id, array $data): bool
    {
        $department = Department::findOrFail($id);
        return $department->update($data);
    }

    /**
     * search departments
     * @param  $searchTerm
     * @return LengthAwarePaginator
     */
    public function search($searchTerm): LengthAwarePaginator
    {
        return Department::where('name', 'like', '%' . $searchTerm . '%')
            ->orWhere('description', 'like', '%' . $searchTerm . '%')
            ->paginate(10);
    }

    /**
     * get all department list
     * @return Collection
     */
    public function getAllDepartment(): Collection
    {
        return Department::all();
    }
}
