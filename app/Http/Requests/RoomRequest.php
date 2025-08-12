<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoomRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:100',
        ];

        if ($this->isMethod('post')) {
            $rules['name'] = 'required|string|max:100|unique:rooms,name';
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $roomId = $this->route('id');
            $rules['name'] = [
                'required',
                'string',
                'max:100',
                Rule::unique('rooms', 'name')->ignore($roomId),
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'The room name is required.',
            'name.unique' => 'The room name has already been taken.',
            'status.required' => 'The status is required.',
        ];
    }
}
