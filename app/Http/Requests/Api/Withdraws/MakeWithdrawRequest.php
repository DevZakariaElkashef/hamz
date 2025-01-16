<?php

namespace App\Http\Requests\Api\Withdraws;

use App\Rules\HasPendingWithdraw;
use Illuminate\Validation\Rule;

class MakeWithdrawRequest extends BaseApiRequest
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
        $withdraw_types = ($this->wallet_type == '0') ? '1' : '0,1';
        return [
            'wallet_type' => [
                'required',
                'in:0,1',
                new HasPendingWithdraw()
            ],
            'withdraw_type' => "required|in:$withdraw_types",
            'amount' => 'required|numeric|min:1|max:' . PHP_INT_MAX,
            'iban' => [
                Rule::requiredIf($this->withdraw_type == '1'),
                'nullable',
                'string',
                'max:250'
            ]
        ];
    }
}
