<?php

namespace App\Http\Requests\rfoof\Employee;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'admin_id' => 'required|exists:users,id',
            'name' => 'required|string',
            'email' => 'required|unique:users,email,' . $this->admin_id,
            'phone' => 'required|unique:users,phone,' . $this->admin_id,
            'password' => 'nullable|string',
            'role_id' => 'nullable|exists:roles,id'
        ];
    }
}
