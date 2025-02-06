<?php

namespace App\Http\Controllers\Coupon\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Coupon\Web\CreateUsedCouponRequest;
use App\Models\Coupon;
use App\Models\User;
use App\Models\UserCoupon;
use Illuminate\Http\Request;

class UsedCouponController extends Controller
{
    protected $limit;

    public function __construct()
    {
        $this->middleware('can:coupon.coupons.index')->only(['index']);
        $this->middleware(['can:coupon.coupons.create', 'coupons'])->only(['create']);
        $this->limit = config('app.pg_limit');
    }

    /*----------------------------------------------------------------------------------------------------*/

    public function index(Request $request)
    {
        $language = app()->getLocale();

        $usedCoupons = UserCoupon::select(
            'user_coupons.id',
            "stores.name_$language AS store_name",
            'users.name AS user_name',
            'users.phone AS user_phone',
            'users.image AS user_image',
            'coupons.code'
        )
            ->join('coupons', 'user_coupons.coupon_id', '=', 'coupons.id')
            ->leftJoin('stores', 'coupons.store_id', '=', 'stores.id')
            ->join('users', 'users.id', '=', 'user_coupons.user_id')
            ->where('user_coupons.app', 'coupons')
            ->when($request->user()->role_id == 3, function ($query) use ($request) {
                $query->where('coupons.user_id', $request->user()->id);
            })
            ->paginate($request->per_page ?? $this->limit);

        return view('coupon.used-coupons.index', compact('usedCoupons'));
    }

    /*----------------------------------------------------------------------------------------------------*/

    public function search(Request $request)
    {
        $language = app()->getLocale();

        $usedCoupons = UserCoupon::select(
            'user_coupons.id',
            "stores.name_$language AS store_name",
            'users.name AS user_name',
            'users.phone AS user_phone',
            'users.image AS user_image',
            'coupons.code'
        )
            ->join('coupons', 'user_coupons.coupon_id', '=', 'coupons.id')
            ->leftJoin('stores', 'coupons.store_id', '=', 'stores.id')
            ->join('users', 'users.id', '=', 'user_coupons.user_id')
            ->where('user_coupons.app', 'coupons')
            ->when($request->user()->role_id == 3, function ($query) use ($request) {
                $query->where('coupons.user_id', $request->user()->id);
            })
            ->where(function ($query) use ($request, $language) {
                $query->where('coupons.code', 'LIKE', "%{$request->search}%")
                    ->orWhere("stores.name_$language", 'LIKE', "%{$request->search}%")
                    ->orWhere('users.name', 'LIKE', "%{$request->search}%")
                    ->orWhere('users.phone', 'LIKE', "%{$request->search}%");
            })
            ->paginate($request->per_page ?? $this->limit);

        return view('coupon.used-coupons.table', compact('usedCoupons'))->render();
    }

    /*----------------------------------------------------------------------------------------------------*/

    public function store(CreateUsedCouponRequest $request)
    {
        $user_id = User::select('id')->where('phone', $request->phone)->firstOrFail()->id;
        $coupon_id = Coupon::select('id')->where('code', $request->code)->firstOrFail()->id;

        UserCoupon::create([
            'user_id' => $user_id,
            'coupon_id' => $coupon_id,
            'app' => 'coupons'
        ]);

        return redirect()->route('coupon.used-coupons.index')->with('success', __('main.created_successffully'));
    }

    /*----------------------------------------------------------------------------------------------------*/

    public function destroy($id)
    {
        UserCoupon::findOrFail($id)->delete();

        return redirect()->route('coupon.used-coupons.index')->with('success', __('main.delete_successffully'));
    }

    /*----------------------------------------------------------------------------------------------------*/

    public function delete(Request $request)
    {
        $ids = explode(',', $request->ids);
        UserCoupon::whereIn('id', $ids)->delete();

        return redirect()->route('coupon.used-coupons.index')->with('success', __('main.delete_successffully'));
    }
}
