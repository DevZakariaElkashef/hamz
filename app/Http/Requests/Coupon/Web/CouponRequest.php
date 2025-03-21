<?php

namespace App\Http\Requests\Coupon\Web;

use App\Models\Subscription;
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
        $expire_date = Subscription::select('expire_date')->where('app', 'coupons')->where('status', 1)->orderBy('expire_date', 'DESC')->first()->expire_date;

        return [
            'code' => 'required|string|max:255',
            'discount' => 'required',
            'max_usage' => 'required|integer',
            'image' => 'nullable|mimes:png,jpg,jpeg',
            'lat' => 'required|string',
            'long' => 'required|string',
            'end_date' => 'required|date-format:Y-m-d|before_or_equal:' . $expire_date
        ];
    }
}
