<?php

namespace App\Http\Requests\Mall\Api;

use Illuminate\Foundation\Http\FormRequest;

class DeleteItemFromCartRequest extends BaseApiRequest
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
            'product_id' => 'required|exists:products,id',
            'cart_id' => 'required|exists:carts,id'
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => __('main.product_id_required'),
            'product_id.exists' => __('main.product_id_exists'),
            'cart_id.required' => __('main.cart_id_required'),
            'cart_id.exists' => __('main.cart_id_exists'),
        ];
    }
}
