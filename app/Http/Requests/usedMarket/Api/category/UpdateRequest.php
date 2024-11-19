<?php

namespace App\Http\Requests\usedMarket\Api\category;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name_ar' => 'required|string',
            'name_en' => 'required|string',
            'image' => 'nullable|file|mimes:png,jpg,jpeg',
            'category_id' => 'required|exists:categories,id'
        ];
    }
}
