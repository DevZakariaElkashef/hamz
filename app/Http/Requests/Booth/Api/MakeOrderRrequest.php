<?php

namespace App\Http\Requests\Booth\Api;

use App\Rules\CheckWalletBalance;
use Illuminate\Foundation\Http\FormRequest;

class MakeOrderRrequest extends BaseApiRequest
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
            'address' => 'required|string',
            'lat' => 'required',
            'lng' => 'required',
            'delivery_type' => 'required|in:1,2,3,4',
            'payment_type' => [
                'required',
                'in:0,1',
                new CheckWalletBalance($this->cart_id)
            ],
            'transaction_id' => 'required_if:payment_type,0',
            'cart_id' => 'required|exists:carts,id'
        ];
    }


    public function messages(): array
    {
        return [
            'address.required' => __('main.address_is_required'),
            'lat.required' => __('main.lat_id_required'),
            'lng.required' => __('main.lng_id_required'),
            'delivery_type.required' => __('main.delivery_type_id_required'),
            'transaction_id.required' => __('main.transaction_id_id_required'),
            'cart_id.required' => __('main.cart_id_required'),

        ];
    }
}
