<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Booth\CartResource as BoothCart;
use App\Http\Resources\Mall\CartResource as MallCart;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\UserCoupon;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CouponController extends Controller
{
    use ApiResponse;
    public function addCouponToCart(Request $request)
    {
        try {
            $request->validate([
                'coupon_code' => 'required|string|exists:coupons,code',
                'cart_id' => 'required|integer|exists:carts,id',
            ]);
        }  catch (ValidationException $e) {
            $errorMessage = $e->validator->errors()->first();
            return $this->sendResponse(400, '', $errorMessage);
        }
        $cart = Cart::find($request->cart_id);
        $coupon = Coupon::active()->where('app', $cart->app)
        ->where('store_id', $cart->store_id)
        ->where('start_date', '<=', now())
        ->where('end_date', '>=', now())
        ->where('code', $request->coupon_code)->first();
        if (!$coupon || ($coupon->users->count() >= $coupon->max_usage) || (UserCoupon::where('coupon_id', $coupon->id)->where('user_id', $request->user()->id)->first())) {
            return $this->sendResponse(400, '', __("main.conpon_not_vaild"));
        }
        $cart->coupon_id = $coupon->id;
        $cart->save();
        // $coupon->max_usage = $coupon->max_usage - 1;
        // $coupon->save();
        return $this->sendResponse(200, '', __("main.conpon_added_successfuly"));
    }

    public function removeCouponFromCart(Request $request)
    {
        try {
            $request->validate([
                'cart_id' => 'required|integer|exists:carts,id',
            ]);
        }  catch (ValidationException $e) {
            $errorMessage = $e->validator->errors()->first();
            return $this->sendResponse(400, '', $errorMessage);
        }
        $cart = Cart::find($request->cart_id);
        // $coupon = Coupon::find($cart->coupon_id);
        // if ($coupon) {
        //     $coupon->max_usage = $coupon->max_usage + 1;
        //     $coupon->save();
        // }
        $cart->coupon_id = null;
        $cart->save();
        return $this->sendResponse(200, '', __("main.conpon_removed_successfuly"));
    }
}
