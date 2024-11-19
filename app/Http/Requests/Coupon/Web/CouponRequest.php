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
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'code' => 'required|required|max:255',
            'discount' => 'required',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|mimes:png,jpg,jpeg'
        ];
    }
}
