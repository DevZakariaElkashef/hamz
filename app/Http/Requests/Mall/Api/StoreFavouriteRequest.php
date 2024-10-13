<?php

namespace App\Http\Requests\Mall\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreFavouriteRequest extends BaseApiRequest
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
            'store_id' => 'required|exists:stores,id'
        ];
    }

    public function messages()
    {
        return [
            'store.required' => __('main.store_required'),
            'store.exists' => __('main.store_exists'),
        ];
    }
}
