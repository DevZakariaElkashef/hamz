<?php

namespace App\Http\Controllers\Coupon\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $total_coupons = Coupon::when(auth()->user()->role_id == 3, function ($query) {
            $query->where('coupons.user_id', auth()->user()->id);
        })->count();
        $total_coupons_uses = Coupon::when(auth()->user()->role_id == 3, function ($query) {
            $query->where('coupons.user_id', auth()->user()->id);
        })->join('user_coupons', 'coupons.id', '=', 'user_coupons.coupon_id')->count();
        $total_coupons_copies = Coupon::when(auth()->user()->role_id == 3, function ($query) {
            $query->where('coupons.user_id', auth()->user()->id);
        })->join('user_coupon_copies', 'coupons.id', '=', 'user_coupon_copies.coupon_id')->count();

        $most_used_coupons = $this->getCouponsByUsage('DESC');
        $least_used_coupons = $this->getCouponsByUsage('ASC');


        return view('coupon.index', compact('total_coupons', 'total_coupons_uses', 'total_coupons_copies', 'most_used_coupons', 'least_used_coupons'));
    }

    /*----------------------------------------------------------------------------------------------------*/

    private function getCouponsByUsage($orderBy)
    {
        return Coupon::select(
            "coupons.id",
            "coupons.store_id",
            "coupons.category_id",
            "coupons.code",
            "coupons.discount",
            "max_usage",
            DB::raw('COUNT(user_coupons.id) as coupons_count'),
            DB::raw('COUNT(user_coupon_copies.id) as coupons_copies_count')
        )
            ->when(auth()->user()->role_id == 3, function ($query) {
                $query->where('coupons.user_id', auth()->user()->id);
            })->leftJoin('user_coupons', 'coupons.id', '=', 'user_coupons.coupon_id')
            ->leftJoin('user_coupon_copies', 'coupons.id', '=', 'user_coupon_copies.coupon_id')
            ->groupBy('coupons.id', "coupons.store_id", "coupons.category_id", "coupons.code", "coupons.discount", 'max_usage')
            ->orderBy('coupons_count', $orderBy)
            ->orderBy('coupons_copies_count', $orderBy)
            ->limit(5)
            ->get();
    }
}
