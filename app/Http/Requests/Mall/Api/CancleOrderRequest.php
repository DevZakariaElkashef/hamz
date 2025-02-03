<?php

namespace App\Http\Requests\Mall\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CancleOrderRequest extends BaseApiRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'order_id' => [
                'required',
                Rule::exists('orders', 'id')->where(function ($query) {
                    $query->where('order_status_id', '1');
                })
            ],
            'reason_id' => 'nullable|exists:cancle_order_reasons,id',
            'reason_text' => 'nullable'
        ];
    }
}
