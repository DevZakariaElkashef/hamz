<?php

namespace App\Http\Requests\Earn\Api;

use App\Rules\ValidUserWallet;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class StoreWithdrowRequest extends BaseApiRequest
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
        $user = $this->user();
        return [
            'iban' => 'required|string',
            'amount' => ['required','numeric', new ValidUserWallet($user)]
        ];
    }
}
