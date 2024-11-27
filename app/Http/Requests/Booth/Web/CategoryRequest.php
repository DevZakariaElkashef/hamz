<?php

namespace App\Http\Requests\Booth\Web;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        $parentValidation = '';
        if (is_numeric($this->parent_id)) {
            $parentValidation = 'exists:categories,id';
        }
        return [
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'image' => 'nullable|mimes:png,jpg,jpeg',
            'is_active' => 'required|boolean',
            'parent_id' => 'nullable|' . $parentValidation,
            'store_id' => 'required|exists:stores,id'
        ];
    }
}