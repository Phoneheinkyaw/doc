<?php

namespace App\Services;

use App\Contracts\Dao\PatientDaoInterface;
use App\Contracts\Services\PatientServiceInterface;
use App\Models\Patient;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class PatientService implements PatientServiceInterface
{
    //
    private PatientDaoInterface $patientDao;

    /**
     * @param PatientDaoInterface $patientDao
     */
    public function __construct(PatientDaoInterface $patientDao)
    {
        $this->patientDao = $patientDao;
    }


    /**
     * create a new patient
     * @param array $data
     * @return Patient
     */
    public function createPatient(array $data): Patient
    {
        return $this->patientDao->createPatient($data);
    }

    /**
     * get all patient
     * @return Collection
     */
    public function getAllPatient(): Collection
    {
        return $this->patientDao->getAllPatient();
    }

    /**
     * delete a patient
     * @param $id
     * @return void
     */
    public function destroy($id)
    {
        return $this->patientDao->destroy($id);
    }

    /** get patients list of a specific doctor
     * @param integer $doctorId
     * @param string $search
     * @return LengthAwarePaginator
     */
    public function patientListByDoctorId(int $doctorId, $search): LengthAwarePaginator
    {
        return $this->patientDao->patientListByDoctorId($doctorId, $search);
    }

    /**
     * get appointments by patient's id
     * @param int $doctorId
     * @param int $patientId
     * @return LengthAwarePaginator
     */
    public function appointmentRecordByPatientId($doctorId, $patientId): LengthAwarePaginator
    {
        return $this->patientDao->appointmentRecordByPatientId($doctorId, $patientId);
    }

    /**
     * get single patient by id
     * @param int $patientId
     * @return Patient
     */
    public function getPatientById($patientId): Patient
    {
        return $this->patientDao->getPatientById($patientId);
    }

    /**
     * update a patient
     * @param $data
     * @return void
     */
    public function updatePatient($data): void
    {
        $filteredData = array_filter($data, function ($value) {
            return !is_null($value) && $value !== '';
        });
        $this->patientDao->updatePatient($filteredData);
    }

    /**
     * Delete a patient
     * @param $patientId
     * @return void
     */
    public function deletePatient($patientId): void
    {
        $this->patientDao->deletePatient($patientId);
    }

    /**
     * @param $searchTerm
     * @return LengthAwarePaginator
     */
    public function searchPatients($searchTerm): LengthAwarePaginator
    {
        return $this->patientDao->searchPatients($searchTerm);
    }

    /**
     * update password
     * @param $patient
     * @param $password
     * @return void
     */
    public function updatePassword($patient, $password): void
    {
        $this->patientDao->updatePassword($patient, $password);
    }

    /**
     * Summary of getById
     * @param int $patientId
     * @return Patient
     */
    public function getById($patientId): Patient
    {
        return $this->patientDao->getById($patientId);
    }
}
