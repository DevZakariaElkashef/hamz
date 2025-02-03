<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CommissionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'mall-value' => 'nullable|integer|min:0|max:100',
            'booth-value' => 'nullable|integer|min:0|max:100',
            'resale-value' => 'nullable|integer|min:0|max:100',
            'rfoof-value' => 'nullable|integer|min:0|max:100',
        ];
    }
}
