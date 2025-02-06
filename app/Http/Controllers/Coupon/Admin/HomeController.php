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
        })
            ->where('coupons.app', 'coupons')
            ->count();
        $total_coupons_uses = Coupon::when(auth()->user()->role_id == 3, function ($query) {
            $query->where('coupons.user_id', auth()->user()->id);
        })
            ->where('coupons.app', 'coupons')
            ->join('user_coupons', 'coupons.id', '=', 'user_coupons.coupon_id')->count();
        $total_coupons_copies = Coupon::when(auth()->user()->role_id == 3, function ($query) {
            $query->where('coupons.user_id', auth()->user()->id);
        })
            ->where('coupons.app', 'coupons')
            ->join('user_coupon_copies', 'coupons.id', '=', 'user_coupon_copies.coupon_id')->count();

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
            DB::raw('SUM(CASE WHEN user_coupons.deleted_at IS NULL THEN 1 ELSE 0 END) as coupons_count'),
            DB::raw('SUM(CASE WHEN user_coupon_copies.deleted_at IS NULL THEN 1 ELSE 0 END) as coupons_copies_count')
        )
            ->leftJoin('user_coupons', 'coupons.id', '=', 'user_coupons.coupon_id')
            ->leftJoin('user_coupon_copies', 'coupons.id', '=', 'user_coupon_copies.coupon_id')
            ->where('coupons.app', 'coupons')
            ->when(auth()->user()->role_id == 3, function ($query) {
                $query->where('coupons.user_id', auth()->user()->id);
            })
            ->groupBy('coupons.id', "coupons.store_id", "coupons.category_id", "coupons.code", "coupons.discount", 'max_usage')
            ->orderBy('coupons_count', $orderBy)
            ->orderBy('coupons_copies_count', $orderBy)
            ->limit(5)
            ->get();
    }
}
