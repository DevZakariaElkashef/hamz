<?php

namespace App\Http\Requests\Mall\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CalcDeliveryRequest extends BaseApiRequest
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
            'delivery_type' => 'required|in:1,2,3,4',
            'lat' => 'required',
            'lng' => 'required',
            'cart_id' => [
            'required',
                Rule::exists('carts', 'id')->where(function ($query) {
                    $query->where('user_id', request()->user()->id)
                    ->where('app', 'mall');
                })
            ]
        ];
    }
}
