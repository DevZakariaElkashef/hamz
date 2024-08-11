<?php

namespace App\Http\Requests\Mall\Api;

use Illuminate\Foundation\Http\FormRequest;

class VerifiyRequest extends BaseApiRequest
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
            'otp' => 'required|exists:users,otp'
        ];
    }

    public function messages()
    {
        return [
            'otp.required' => __('mall.otp_required'),
            'otp.exists' => __('mall.otp_not_found'),
        ];
    }
}
