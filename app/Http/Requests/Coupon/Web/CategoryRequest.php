<?php

namespace App\Http\Requests\Coupon\Web;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
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
        ];
    }
}
