<?php

namespace App\Http\Requests\usedMarket\Role;

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
            'role_id' => 'required|exists:roles,id',
            'name' => 'required|unique:roles,name,' . $this->role_id,
            'name_en' => 'required|unique:roles,name_en,' . $this->role_id,
            'permissions' => 'required|array'
        ];
    }
}
