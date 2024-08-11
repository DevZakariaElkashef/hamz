<?php

namespace App\Http\Requests\Mall\Api;

use App\Rules\ValidUserActive;
use App\Rules\ValidUserRole;
use App\Rules\ValidUserPassword;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends BaseApiRequest
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
        $phone = $this->input('phone');
        $password = $this->input('password');

        return [
            'phone' => ['required', 'exists:users,phone', new ValidUserRole($phone), new ValidUserActive($phone)],
            'password' => ['required', new ValidUserPassword($phone, $password)],
        ];
    }

    public function messages()
    {
        return [
            'phone.required' => __('mall.phone_required'),
            'phone.exists' => __('mall.phone_exists'),
            'password.required' => __('mall.password_required'),
        ];
    }
}
