<?php

namespace App\Services;

use App\Contracts\Dao\DepartmentDaoInterface;
use App\Contracts\Services\DepartmentServiceInterface;
use App\Models\Department;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class DepartmentService implements DepartmentServiceInterface
{
    protected DepartmentDaoInterface $departmentDao;

    public function __construct(DepartmentDaoInterface $departmentDao)
    {
        $this->departmentDao = $departmentDao;
    }

    /**
     * Retrieve all departments.
     * @return LengthAwarePaginator
     */
    public function getAll(): LengthAwarePaginator
    {
        return $this->departmentDao->getAll();
    }

    /**
     * Store a new department.
     * @param array $data
     * @return Department
     */
    public function storeDepartment(array $data): Department
    {
        return $this->departmentDao->createDepartment($data);
    }

    /**
     * Get a department by its ID.
     * @param int $id
     * @return Department|null
     */
    public function getDepartmentById($id): ?Department
    {
        return $this->departmentDao->findById($id);
    }

    /**
     * Update a department by its ID.
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateDepartment($id, array $data): bool
    {
        return $this->departmentDao->update($id, $data);
    }

    /**
     * Delete a department by its ID.
     * @param int $id
     * @return bool
     */
    public function destroy($id): bool
    {
        return $this->departmentDao->destroy($id);
    }

    /**
     * Search for departments by a search term.
     * @param string $searchTerm
     * @return LengthAwarePaginator
     */
    public function search($searchTerm): LengthAwarePaginator
    {
        return $this->departmentDao->search($searchTerm);
    }

    /**
     * get all department list
     * @return Collection
     */
    public function getAllDepartment(): Collection
    {
        return $this->departmentDao->getAllDepartment();
    }
}
