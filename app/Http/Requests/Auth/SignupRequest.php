<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
class SignupRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'image' => 'nullable|mimes:png,jpg,jpeg,webp',
            'name' => 'required|string|max:250',
            'email' => 'required|email:filter|max:250',
            'phone' => 'required|string|max:50',
            'city_id' => 'required|exists:cities,id',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'required|accepted'
        ];
    }
}
