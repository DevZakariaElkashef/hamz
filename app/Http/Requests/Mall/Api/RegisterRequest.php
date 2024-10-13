<?php

namespace App\Http\Requests\Mall\Api;

use App\Rules\ValidPhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends BaseApiRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => ['required', new ValidPhoneNumber(), 'unique:users,phone'],
            'password' => 'required|min:8|max:255'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('main.name.required'),
            'name.string' => __('main.name.string'),
            'name.max' => __('main.name.max'),

            'email.required' => __('main.email.required'),
            'email.email' => __('main.email.email'),
            'email.unique' => __('main.email.unique'),

            'phone.required' => __('main.phone.required'),
            'phone.unique' => __('main.phone.unique'),
            'phone.phone_format' => __('main.phone.phone_format'),

            'password.required' => __('main.password.required'),
            'password.min' => __('main.password.min'),
            'password.max' => __('main.password.max'),
        ];
    }
}
