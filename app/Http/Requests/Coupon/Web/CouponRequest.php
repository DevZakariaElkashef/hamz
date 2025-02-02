<?php

namespace App\Http\Requests\Coupon\Web;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code' => 'required|string|max:255',
            'discount' => 'required',
            'max_usage' => 'required|integer',
            'image' => 'nullable|mimes:png,jpg,jpeg',
            'lat' => 'required|string',
            'long' => 'required|string',
        ];
    }
}
