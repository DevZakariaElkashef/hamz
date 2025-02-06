<?php

namespace App\Http\Requests\Coupon\Web;

use App\Models\UserCoupon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUsedCouponRequest extends FormRequest
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
        $count_uses = UserCoupon::join('coupons', 'coupons.id', '=', 'user_coupons.coupon_id')
            ->where('coupons.app', 'coupons')
            ->where('coupons.code', $this->code)
            ->count();
        $coupon_code = !UserCoupon::join('coupons', 'coupons.id', '=', 'user_coupons.coupon_id')
            ->join('users', 'user_coupons.user_id', '=', 'users.id')
            ->where('coupons.app', 'coupons')
            ->where('coupons.code', $this->code)
            ->where('users.phone', $this->phone)
            ->exists() ? $this->code : null;

        return [
            'phone' => [
                'required',
                Rule::exists('users')->where(function ($query) {
                    $query->where('role_id', '2');
                })
            ],
            'code' => [
                'required',
                Rule::exists('coupons')->where(function ($query) use ($count_uses) {
                    $query->when($this->user()->role_id == 3, function ($query) {
                        $query->where('user_id', $this->user()->id);
                    })
                        ->where('is_active', '1')
                        ->where('end_date', '>', date('Y-m-d'))
                        ->where('app', 'coupons')
                        ->where('max_usage', '>', $count_uses);
                }),
                Rule::in($coupon_code)
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'code.exists' => __('main.invalid_coupon'),
            'code.in' =>  __('main.used_coupon')
        ];
    }
}
