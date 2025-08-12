<?php

namespace App\Services;

use App\Contracts\Dao\DoctorDaoInterface;
use App\Contracts\Services\DoctorServiceInterface;
use App\Models\Doctor;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DoctorService implements DoctorServiceInterface
{
    protected $doctorDao;

    /**
     * Create a new instance of DoctorService.
     *
     * @param DoctorDaoInterface $doctorDao
     */
    public function __construct(DoctorDaoInterface $doctorDao)
    {
        $this->doctorDao = $doctorDao;
    }

    /**
     * Retrieve all doctors.
     * @return LengthAwarePaginator
     */
    public function getAll(): LengthAwarePaginator
    {
        return $this->doctorDao->getAll();
    }

    /**
     * Retrieve a doctor by their ID.
     * @param int $id The ID of the doctor.
     * @return  doctor
     */
    public function getDoctorById($id): Doctor
    {
        return $this->doctorDao->getDoctorById($id);
    }

    /**
     * Retrieve a doctor by their email.
     * @param int $email
     * @return doctor
     */
    public function getDoctorByEmail($email): Doctor
    {
        return $this->doctorDao->findByEmail($email);
    }

    /**
     * Update the doctor's information.
     * @param int $id
     * @param array $data
     * @return Doctor
     */
    public function updateDoctor($id, array $data): Doctor
    {
        if (isset($data['image'])) {
            $imagePath = $data['image']->store('images/doctors', 'public');
            $data['image'] = $imagePath;
        }
        return $this->doctorDao->updateDoctor($id, $data);
    }

    /**
     * Create a new doctor.
     * @param array $data The data for the new doctor.
     * @return Doctor
     */
    public function create(array $data): Doctor
    {
        $data['password'] = Hash::make($data['password']);
        if (isset($data['image'])) {
            $data['image'] = $data['image']->store('doctors', 'public'); // Stores in "storage/app/public/doctors"
        } else {
            $data['image'] = null;
        }
        return $this->doctorDao->create($data);
    }

    /**
     * Delete a doctor by their ID.
     * @param int $id The ID of the doctor to delete.
     * @return bool
     */
    public function destroy($id): bool
    {
        return $this->doctorDao->destroy($id);
    }

    /**
     * hasAppointments function
     * @param int $doctorId
     * @return boolean
     */
    public function hasAppointments($doctorId): bool
    {
        return $this->doctorDao->hasAppointments($doctorId);
    }

    /**
     * Upload the profile image for the authenticated doctor.
     *
     * @param array $validatedData The validated data containing the image.
     * @return JsonResponse  A JSON response with the image path and message.
     */
    public function uploadProfileImage(array $validatedData): JsonResponse
    {
        if (isset($validatedData['image'])) {
            $file = $validatedData['image'];
            $path = $file->store('profile_images', 'public');
            $doctor = Auth::guard('doctors')->user();
            $doctor->image = $path;
            $this->doctorDao->uploadProfileImage($doctor);
            return response()->json([
                'image' => asset('storage/' . $path),
                'message' => 'Profile image updated successfully!',
            ]);
        }
        return response()->json(['error' => 'No file uploaded.'], 400);
    }

    /**
     * Retrieve doctors from a specific department by ID.
     * @param int $departmentId The ID of the department.
     * @return Collection
     */
    public function getDocFromDepartmentId($departmentId): Collection
    {
        return $this->doctorDao->getDocFromDepartmentId($departmentId);
    }

    /**
     * Change the password for the specified doctor.
     * @param mixed $doctor The doctor whose password is being changed.
     * @param string $newPassword The new password.
     * @return boolean
     */
    public function changePassword($doctor, $newPassword): bool
    {
        return $this->doctorDao->updatePassword($doctor, $newPassword);
    }

    /**
     * Undocumented function
     * @param object $doctor
     * @param string $newPassword
     * @return boolean
     */
    public function resetDoctorPassword($doctor, $newPassword): bool
    {
        return $this->doctorDao->updatePassword($doctor, $newPassword);
    }

    /**
     * searchDoctors function
     * @param string $keyword
     * @return void
     */
    public function searchDoctors(string $keyword)
    {
        return $this->doctorDao->searchDoctors($keyword);
    }

    /**
     * Summary of getLatestDoctor
     * @return collection
     */
    public function getLatestDoctor(): Collection
    {
        return $this->doctorDao->getLatestDoctor();
    }
}
