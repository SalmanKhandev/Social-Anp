<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => ['required', Rule::unique('users')->ignore($this->user_id)],
        ];
    }


    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'email.required' => 'Email  is required',
            'email.unique' => 'Provided email  already exists',
        ];
    }
}
