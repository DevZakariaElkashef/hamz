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
            'name.required' => __('mall.name.required'),
            'name.string' => __('mall.name.string'),
            'name.max' => __('mall.name.max'),

            'email.required' => __('mall.email.required'),
            'email.email' => __('mall.email.email'),
            'email.unique' => __('mall.email.unique'),

            'phone.required' => __('mall.phone.required'),
            'phone.unique' => __('mall.phone.unique'),
            'phone.phone_format' => __('mall.phone.phone_format'),

            'password.required' => __('mall.password.required'),
            'password.min' => __('mall.password.min'),
            'password.max' => __('mall.password.max'),
        ];
    }
}
