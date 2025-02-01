<?php

namespace App\Http\Controllers\Coupon\Api;

use App;
use App\Http\Controllers\Controller;
use App\Http\Resources\Coupon\CategoriesResource;
use App\Http\Resources\Coupon\CouponsResource;
use App\Http\Resources\Coupon\SliderResource;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Slider;
use App\Models\UserCoupon;
use App\Models\UserCouponCopy;
use App\Traits\ApiResponse;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    use GeneralTrait, ApiResponse;
    public function __construct()
    {
        App::setLocale(request()->header('lang') ?? 'ar');
    }
    public function home()
    {
        try {
            $ad = Slider::coupon()->active()->fixed()->first();
            $data = [
                'ad' => $ad ? new SliderResource($ad) : null,
                'sliders' => SliderResource::collection(Slider::coupon()->active()->scrollable()->get()),

            ];

            return $this->sendResponse(200, $data);

        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }

    public function categories(Request $request)
    {
        try {
            $categories = Category::query();

            $categories = $categories->coupon()->active();

            if ($request->has('search') && !empty($request->search)) {
                $searchTerm = $request->search;
                // Assuming you're searching by product name or description
                $categories = $categories->where(function ($query) use ($searchTerm) {
                    $query->where('name_ar', 'like', "%{$searchTerm}%")
                        ->orWhere('name_en', 'like', "%{$searchTerm}%");
                });
            }
            $categories = CategoriesResource::collection($categories->latest()->paginate(30));

            return $this->returnData("data", ["categories" => $categories], __('main.returnData'));

        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }

    public function coupons(Request $request, $category_id)
    {
        try {
            $coupons = Coupon::query();

            $coupons = $coupons->coupon()->where('category_id', $category_id)
            ->where(function ($query) {
                $query->where('start_date', '<=', now())
                    ->where('end_date', '>=', now());
            });

            if ($request->has('search') && !empty($request->search)) {
                $searchTerm = $request->search;
                $coupons = $coupons->where(function ($query) use ($searchTerm) {
                    $query->where('title_ar', 'like', "%{$searchTerm}%")
                        ->orWhere('title_en', 'like', "%{$searchTerm}%");
                });
            }
            $coupons = CouponsResource::collection($coupons->latest()->paginate(30));

            return $this->returnData("data", ["coupons" => $coupons], __('main.returnData'));

        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }

    public function useCoupon(Request $request, $code)
    {
        try {
            $coupon = Coupon::coupon()->active()->where('code', $code)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())->first();
            if (!$coupon || ($coupon->users->count() >= $coupon->max_usage) || (UserCoupon::where('coupon_id', $coupon->id)->where('user_id', $request->user()->id)->first())) {
                return $this->sendResponse(400, '', __("main.conpon_not_vaild"));
            }
            if($coupon){
                UserCoupon::create([
                    'user_id' => $request->user()->id,
                    'coupon_id' => $coupon->id,
                    'app' => 'coupons',
                ]);
            }

            return $this->sendResponse( 200, '',__('main.returnData'));

        } catch (\Throwable $e) {
            return $this->sendResponse(403,'', $e->getMessage());
        }
    }

    public function copyCoupon(Request $request, $code)
    {
        try {
            $coupon = Coupon::coupon()->active()->where('code', $code)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())->first();
            if (!$coupon || ($coupon->users->count() >= $coupon->max_usage) || (UserCoupon::where('coupon_id', $coupon->id)->where('user_id', $request->user()->id)->first())) {
                return $this->sendResponse(400, '', __("main.conpon_not_vaild"));
            }
            if($coupon){
                UserCouponCopy::updateOrCreate(
                    [
                        'user_id' => $request->user()->id,
                        'coupon_id' => $coupon->id,
                    ],
                    [
                        'app' => 'coupons',
                    ]
                );
            }

            return $this->sendResponse( 200, '',__('main.returnData'));

        } catch (\Throwable $e) {
            return $this->sendResponse(403,'', $e->getMessage());
        }
    }
}
