<?php

namespace App\Http\Requests\Booth\Web;

use Illuminate\Foundation\Http\FormRequest;

class OptionRequest extends FormRequest
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
            'value_ar' => 'required|string|max:255',
            'value_en' => 'required|string|max:255',
            'is_active' => 'required|boolean',
            'attribute_id' => 'required|exists:attributes,id'
        ];
    }
}
