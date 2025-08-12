<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
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
        $id = $this->route('id');
        $GENDER = array_keys(config('constants.genders'));

        if (request()->routeIs('patient.authenticate')) {
            return [
                'email' => ['required', 'email', 'max:100'],
                'password' => ['required', 'string', 'min:8', 'max:255'],
            ];
        }
        if (request()->routeIs('patient.update')) {
            return [
                'id' => ['required', 'exists:patients,id'],
                'name' => ['required', 'string', 'max:100'],
                'email' => ['required', 'email', 'max:100'],
                'phone' => ['required', 'max:20', 'min:8'],
                'address' => ['required', 'string'],
                'gender' => ['required', 'in:' . implode(',', $GENDER)],
            ];
        }
        if (request()->routeIs('patient.update-password')) {
            return [
                'current_password' => ['required'],
                'new_password' => ['required', 'string', 'min:8', 'max:255', 'confirmed', 'different:current_password'],
                'new_password_confirmation' => ['required']
            ];
        }
        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:patients,email,' . $id],
            'password' => $this->isMethod('post')
                ? ['required', 'string', 'min:8', 'max:255']
                : ['nullable', 'string', 'min:8', 'max:255'],
            'phone' => ['required', 'max:15', 'regex:/^[0-9]+$/'],
            'address' => ['required', 'string'],
            'gender' => ['required', 'in:' . implode(',', $GENDER)]
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'Invalid user action',
            'id.exists' => 'Unauthorized user.',

            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name cannot exceed 100 characters.',

            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.max' => 'The email cannot exceed 100 characters.',
            'email.unique' => 'This email is already taken.',

            'password.required' => 'The password field is required on creation.',
            'password.string' => 'The password must be a string.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.max' => 'The password cannot exceed 255 characters.',

            'current_password.required' => 'Current password field is required.',

            'new_password.required' => 'New password field is required.',
            'new_password.string' => 'The password must be a string.',
            'new_password.min' => 'The password must be at least 8 characters.',
            'new_password.max' => 'The password cannot exceed 255 characters.',
            'new_password.confirmed' => 'Passwords do not match.',
            'new_password.different' => 'Must not be the same as previous password.',

            'new_password_confirmation.required' => 'This field cannot be empty.',

            'phone.required' => 'The phone field is required.',
            'phone.max' => 'The phone cannot exceed 15 characters.',
            'phone.regex' => 'The phone number must contain only digits.',

            'address.required' => 'The address field is required.',
            'address.string' => 'The address must be a string.',

            'gender.required' => 'Select your gender.',
            'gender.in' => 'The gender must be male, female, or other.',
        ];
    }
}
