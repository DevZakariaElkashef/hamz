<?php

namespace App\Http\Requests\Mall\Api;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends BaseApiRequest
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
        $userId = $this->user()->id; // Get the current user's ID

        return [
            'name' => 'nullable|string|max:255',
            'email' => [
                'nullable',
                'email',
                Rule::unique('users', 'email')->ignore($userId)
            ],
            'password' => [
                'nullable',
                'min:8',
                'max:255',
                'confirmed' // Ensure the field is named `password_confirmation` for confirmation
            ],
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => __('main.email_already_taken'),
            'password.confirmed' => __('main.password_confirmation_mismatch'),
        ];
    }
}
