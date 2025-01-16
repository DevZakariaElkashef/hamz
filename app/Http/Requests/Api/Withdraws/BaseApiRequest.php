<?php

namespace App\Http\Requests\Api\Withdraws;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseApiRequest extends FormRequest
{
    use ApiResponse;

    protected function failedValidation(Validator $validator)
    {
        $firstError = $validator->errors()->first();

        $response = $this->sendResponse(403, '', $firstError);

        throw new HttpResponseException($response);
    }
}
