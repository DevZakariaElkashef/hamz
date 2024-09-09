<?php

namespace App\Http\Requests\Mall\Web;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
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
            'code' => 'required|string|max:255',
            'discount' => 'required|numeric',
            'max_usage' => 'required|integer',
            'is_active' => 'required|boolean',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ];
    }
}
