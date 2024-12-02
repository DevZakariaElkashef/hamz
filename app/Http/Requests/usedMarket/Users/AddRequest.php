<?php

namespace App\Http\Requests\usedMarket\Users;

use Illuminate\Foundation\Http\FormRequest;

class AddRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'nullable|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'password' => 'required',
            'image' => 'nullable|file|mimes:png,jpg,jpeg',
        ];
    }
}
