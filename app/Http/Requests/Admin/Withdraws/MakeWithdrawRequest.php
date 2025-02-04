<?php

namespace App\Http\Requests\Admin\Withdraws;

use App\Rules\HasPendingWithdraw;
use Illuminate\Foundation\Http\FormRequest;

class MakeWithdrawRequest extends FormRequest
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
        $this->merge([
            'wallet_type' => '0'
        ]);

        return [
            'wallet_type' => [
                new HasPendingWithdraw()
            ],
            'amount' => 'required|numeric|min:1|max:' . PHP_INT_MAX,
            'iban' => 'required|string|max:250'
        ];
    }
}
