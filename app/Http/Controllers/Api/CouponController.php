<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
                'coupon_code' => 'required|string',
                'cart_id' => 'required|integer',
            ]);
        }  catch (ValidationException $e) {
            $errorMessage = $e->validator->errors()->first();
            return $this->sendResponse(400, '', $errorMessage);
        }
        $user = $request->user();
        $rateableType = $request->rateable_type;
        $rateableId = $request->rateable_id;

        // Check if the rating already exists
        $existingRating = OrderStoreRating::where('rateable_type', $rateableType)
            ->where('rateable_id', $rateableId)->where('user_id', $user->id)
            ->first();
        if ($existingRating) {
            return $this->sendResponse(400, '', __("main.rate_exist"));
        }
        // Check if the rateable entity exists
        $rateableModel = $rateableType::where($rateableId)->where('app', $request->app);
        if (!$rateableModel) {
            return $this->sendResponse(400, '', __("main.item_not_exist"));
        }

        $newRating = OrderStoreRating::create([
            'rateable_type' => $rateableType,
            'rateable_id' => $rateableId,
            'rating' => $request->rating,
            'app' => $request->app,
            'user_id' => $user->id,
            'comment' => $request->comment,
        ]);

        return $this->sendResponse(200, $newRating, __("main.rate_Done"));
    }
}
