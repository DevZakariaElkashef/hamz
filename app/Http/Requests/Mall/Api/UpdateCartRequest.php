<?php

namespace App\Http\Requests\Mall\Api;

class UpdateCartRequest extends BaseApiRequest
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
            'qty' => 'required|gt:0',
            'product_id' => ['required', 'exists:products,id']
        ];
    }

    public function messages(): array
    {
        return [
            'qty.required' => __('main.qty_required'),
            'qty.gt' => __('main.qty_gt'),
            'product_id.required' => __('main.product_id_required'),
            'product_id.exists' => __('main.product_id_exists'),
        ];
    }
}
