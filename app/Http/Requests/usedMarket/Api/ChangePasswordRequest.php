<?php

namespace App\Http\Requests\usedMarket\Api;

use App\Traits\GeneralTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ChangePasswordRequest extends FormRequest
{
    use GeneralTrait;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'phone' => 'required|exists:users,phone',
            'password' => 'required_with:confirm_password|same:confirm_password'
        ];
    }


    protected function failedValidation(Validator $validator): void
    {
        $code = $this->returnCodeAccordingToInput($validator);
        throw new HttpResponseException($this->returnValidationError($code, $validator));
    }
}
