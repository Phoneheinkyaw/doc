<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'patientId' => [
                'required',
                'exists:patients,id',
            ],
            'date' => [
                'required',
                'date',
                'after:today',
                'before_or_equal:' . now()->addMonths(3)->toDateString(),
                Rule::unique('appointments', 'appointment_date')->where(function ($query) {
                    return $query->where('patient_id', $this->patientId);
                }),
            ],
            'department' => [
                'required',
                'exists:departments,id',
            ],
            'doctor' => [
                'required',
                'exists:doctors,id',
            ],
            'room' => [
                'required',
                'in:0,1',
            ],
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'patientId.required' => 'Invalid user action the user must logged in to make an appointment.',
            'patientId.exists' => 'Invalid user.',
            'date.required' => 'The appointment date is required.',
            'date.date' => 'The appointment date must be a valid date.',
            'date.after' => 'The appointment date must be after today.',
            'date.before_or_equal' => 'The appointment date must be within 3 months from today.',
            'date.unique' => 'You have already made an appointment for that day.',
            'department.required' => 'Please select a department.',
            'department.exists' => 'The selected department does not exist.',
            'doctor.required' => 'Please select a doctor.',
            'doctor.exists' => 'The selected doctor does not exist.',
            'room.required' => 'Please select whether a room is needed.',
            'room.in' => 'Invalid room request',
        ];
    }
}
