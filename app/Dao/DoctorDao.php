<?php

namespace App\Dao;

use App\Contracts\Dao\DoctorDaoInterface;
use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DoctorDao implements DoctorDaoInterface
{
    /**
     * Retrieve all doctors with pagination.
     * @return LengthAwarePaginator
     */
    public function getAll(): LengthAwarePaginator
    {
        return Doctor::paginate(10);
    }

    /**
     * Retrieve a doctor by their ID.
     * @param int $id The ID of the doctor to retrieve.
     * @return Doctor
     */
    public function getDoctorById($id): ?Doctor
    {
        return Doctor::findOrfail($id);
    }

    /**
     * Create a new doctor record.
     * @param array $data The data for the new doctor.
     * @return Doctor
     */
    public function create(array $data): Doctor
    {
        return Doctor::create($data);
    }

    /**
     * Delete a doctor by their ID.
     * @param int $id
     * @return bool
     */
    public function destroy($id): bool
    {
        $doctor = Doctor::findOrFail($id);
        if ($doctor->image) {
            Storage::delete($doctor->image);
        }
        return $doctor->delete();
    }

    /**
     * hasAppointment check function
     *
     * @param int $doctorId
     * @return boolean
     */
    public function hasAppointments($doctorId): bool
    {
        return Appointment::where('doctor_id', $doctorId)->exists();
    }

    /**
     * Update the doctor's information.
     * @param int $id The ID of the doctor to update.
     * @param array $data The updated data for the doctor.
     * @return Doctor  The updated doctor instance.
     */
    public function updateDoctor($id, array $data): Doctor
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->update($data);
        return $doctor;
    }

    /**
     * Upload and save the doctor's profile image.
     * @param Doctor $doctor The doctor instance to save.
     * @return bool  True if the doctor instance was saved successfully, false otherwise.
     */
    public function uploadProfileImage($doctor): bool
    {
        return $doctor->save();
    }

    /**
     * Retrieve doctors from a specific department by its ID.
     * @param int $departmentId The ID of the department.
     * @return Collection
     */
    public function getDocFromDepartmentId($departmentId): Collection
    {
        return Doctor::where('department_id', $departmentId)->orderBy('name', 'asc')->get();
    }

    /**
     * Update the password for the specified doctor.
     * @param $doctor
     * @param string $newPassword
     * @return bool
     */
    public function updatePassword($doctor, $newPassword): bool
    {
        $doctor->password = Hash::make($newPassword);
        return $doctor->save();
    }

    /**
     * Find a doctor by their email address.
     * @param string $email The email address to search for.
     * @return Doctor
     */
    public function findByEmail($email): Doctor
    {
        return Doctor::where('email', $email)->first();
    }

    /**
     * searchDoctors function
     * @param string $search
     * @return LengthAwarePaginator
     */
    public function searchDoctors(string $search): LengthAwarePaginator
    {
        return Doctor::with('department')
            ->where('name', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%')
            ->orWhere('phone', 'like', '%' . $search . '%')
            ->orWhere('licence_number', 'like', '%' . $search . '%')
            ->orWhereHas('department', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->paginate(10);
    }

    /**
     * Summary of getLatestDoctor
     * @return Collection
     */
    public function getLatestDoctor(): Collection
    {
        return Doctor::with('department')
            ->orderBy('id', 'desc')
            ->take(4)
            ->get();
    }
}
