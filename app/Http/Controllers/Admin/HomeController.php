<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\Section;
use App\Models\Store;
use App\Models\UserCoupon;
use App\Models\UserCouponCopy;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $user = request()->user();

        // Mall
        $totalMallStores = Store::active()->where('app', 'mall')->count();
        $totalMallSections = Section::active()->mall()->count();
        $totalMallCats = Category::active()->mall();
        $totalMallProducts = Product::active()->mall();
        $totalMallOrders = Order::mall();
        $totalMallCoupons = Coupon::mall();

        // Booth
        $totalBoothStores = Store::active()->where('app', 'booth')->count();
        $totalBoothSections = Section::active()->booth()->count();
        $totalBoothCats = Category::active()->booth();
        $totalBoothProducts = Product::active()->booth();
        $totalBoothOrders = Order::booth();
        $totalBoothCoupons = Coupon::booth();

        // Coupons
        $totalCouponsCats = Category::active()->coupon()->count();
        $totalCoupons = Coupon::active()->coupon();

        if ($user->role->name == "seller") {
            // Mall
            $storeMall = Store::active()->mall()->where('user_id', $user->id)->first();
            $storeMallId = '';
            if ($storeMall) {
                $storeMallId = $storeMall->id;
            }

            $totalMallCats = $totalMallCats->where('store_id', $storeMallId);
            $totalMallProducts = $totalMallProducts->whereHas('store', function ($query) use ($storeMallId) {
                $query->where('stores.id', $storeMallId);
            });
            $totalMallOrders = $totalMallOrders->where('store_id', $storeMallId);
            $totalMallCoupons = $totalMallCoupons->where('store_id', $storeMallId);

            // Booth
            $storeBooth = Store::active()->booth()->where('user_id', $user->id)->first();
            $storeBoothId = '';
            if ($storeBooth) {
                $storeBoothId = $storeBooth->id;
            }

            $totalBoothCats = $totalBoothCats->where('store_id', $storeBoothId);
            $totalBoothProducts = $totalBoothProducts->whereHas('store', function ($query) use ($storeBoothId) {
                $query->where('stores.id', $storeBoothId);
            });
            $totalBoothOrders = $totalBoothOrders->where('store_id', $storeBoothId);
            $totalBoothCoupons = $totalBoothCoupons->where('store_id', $storeBoothId);

            // Coupons
            $storeIds = Store::active()->where('user_id', $user->id)->pluck('id');
            $totalCoupons = $totalCoupons->whereIn('store_id', $storeIds);


        }
        // Mall
        $totalMallCats = $totalMallCats->count();
        $totalMallProducts = $totalMallProducts->count();
        $totalMallOrders = $totalMallOrders->count();
        $totalMallCoupons = $totalMallCoupons->count();

        // Booth
        $totalBoothCats = $totalBoothCats->count();
        $totalBoothProducts = $totalBoothProducts->count();
        $totalBoothOrders = $totalBoothOrders->count();
        $totalBoothCoupons = $totalBoothCoupons->count();

        // Coupons
        $couponsIds = $totalCoupons->pluck('id');
        $copiesCount = UserCouponCopy::whereIn('coupon_id', $couponsIds)->count();
        $usedCount = UserCoupon::whereIn('coupon_id', $couponsIds)->count();
        $totalCoupons = $totalCoupons->count();

        return view('index', compact(
            'totalMallStores',
            'totalMallSections',
            'totalMallCats',
            'totalMallProducts',
            'totalMallOrders',
            'totalMallCoupons',

            'totalBoothStores',
            'totalBoothSections',
            'totalBoothCats',
            'totalBoothProducts',
            'totalBoothOrders',
            'totalBoothCoupons',

            'totalCouponsCats',
            'totalCoupons',
            'copiesCount',
            'usedCount',
        ));
    }
}
