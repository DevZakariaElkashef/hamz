<?php

namespace App\Http\Requests\Mall\Api;

use Illuminate\Foundation\Http\FormRequest;

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
            'order_id' => 'required|exists:orders,id',
            'reason_id' => 'nullable|exists:cancle_order_reasons,id',
            'reason_text' => 'nullable'
        ];
    }
}
