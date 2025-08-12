<?php

namespace App\Dao;

use App\Contracts\Dao\PatientDaoInterface;
use App\Models\Appointment;
use App\Models\Patient;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PatientDao implements PatientDaoInterface
{
    /**
     * crete a new patient
     * @param array $data
     * @return Patient
     */
    public function createPatient(array $data): Patient
    {
        return Patient::create($data);
    }

    /**
     * get all patients
     *
     */
    public function getAllPatient(): Collection
    {
        return Patient::all();
    }

    /**
     * delete a patient
     * @param $id
     * @return bool|null`
     */
    public function destroy($id)
    {
        $doctor = Patient::findOrFail($id);

        return $doctor->delete();
    }

    /**
     * get patients list of a specific doctor
     * @param integer $doctorId
     * @param string $search
     * @return LengthAwarePaginator
     */
    public function patientListByDoctorId(int $doctorId, $search): LengthAwarePaginator
    {
        $patients = DB::table('appointments')
            ->join('patients', 'appointments.patient_id', '=', 'patients.id')
            ->select('patient_id', 'patients.name', DB::raw('count(*)
             as total_appointments'))
            ->where('appointments.doctor_id', $doctorId)
            ->groupBy('patient_id', 'patients.name');
        if ($search) {
            $patients->where('patients.name', 'like', '%' . $search . '%');
        }
        if (!empty($search)) {
            $patients->where('patients.name', 'like', '%' . $search . '%');
        }
        return $patients->paginate(10)->appends(['search' => $search]);
    }

    /**
     * get appointments by patient's id
     * @param int $doctorId
     * @param int $patientId
     * @return LengthAwarePaginator
     * @throws Exception
     */
    public function appointmentRecordByPatientId($doctorId, $patientId): LengthAwarePaginator
    {
        try {
            return Appointment::where('patient_id', $patientId)
                ->where('doctor_id', $doctorId)
                ->paginate(10);
        } catch (Exception $e) {
            throw new Exception("An error occurred while retrieving the patient's appointment");
        }
    }

    /**
     * get single patient by id
     * @param int $patientId
     * @return Patient
     */
    public function getPatientById($patientId): Patient
    {
        return Patient::findOrFail($patientId);
    }

    /**
     * update patient
     * @param $data
     * @return void
     * @throws Exception
     */
    public function updatePatient($data): void
    {
        try {
            $patient = Patient::findOrFail($data['id']);
            $patient->update($data);
        } catch (Exception $e) {
            throw new Exception("An error occurred while updating the patient");
        }
    }

    /**
     * Delete a patient
     * @param $patientId
     * @return void
     * @throws Exception
     */
    public function deletePatient($patientId): void
    {
        try {
            $patient = Patient::findOrFail($patientId);
            $patient->delete();
        } catch (\Exception $e) {
            throw new \Exception("Error deleting the patient: " . "You currently have an ongoing appointment history.");
        }
    }

    /**
     * search patients
     * @param string $keyword
     * @return LengthAwarePaginator
     */
    public function searchPatients(string $keyword): LengthAwarePaginator
    {
        $status = config('constants.genders');
        $searchLower = strtolower(trim($keyword));

        $query = Patient::where(function ($query) use ($keyword, $searchLower) {
            $query->where('name', 'like', '%' . $keyword . '%')
                ->orWhere('email', 'like', '%' . $keyword . '%')
                ->orWhere('phone', 'like', '%' . $keyword . '%')
                ->orWhere('address', 'like', '%' . $keyword . '%')
                ->orWhere(function ($query) use ($searchLower) {
                    if ($searchLower === 'male') {
                        $query->orWhere('gender', 1);
                    }
                    if ($searchLower === 'female') {
                        $query->orWhere('gender', 2);
                    }
                    if ($searchLower === 'other') {
                        $query->orWhere('gender', 3);
                    }
                });
        });
        return $query->paginate(10)->appends(['search' => $keyword]);
    }

    /**
     * update password
     * @param $patient
     * @param $password
     * @return void
     */
    public function updatePassword($patient, $password): void
    {
        $patient->password = Hash::make($password);
        $patient->save();
    }

    /**
     * get patient by id
     * @param int $patientId
     * @return Patient
     */
    public function getById($patientId): Patient
    {
        $patient = Patient::where('id', $patientId)->first();
        if (is_null($patient)) {
            abort(404, "Patient not found with ID: $patientId.");
        }
        return $patient;
    }
}
