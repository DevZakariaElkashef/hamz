<?php

namespace App\Repositories\Mall;

use App\Models\Coupon;
use App\Models\Store;
use App\Traits\ImageUploadTrait;

class CouponRepository
{
    use ImageUploadTrait;
    protected $limit;

    public function __construct()
    {
        $this->limit = config('app.pg_limit');
    }

    public function index($request)
    {
        $user = $request->user();
        $coupons = Coupon::mall();
        if ($user->role->name == 'seller') {
            $store = Store::active()->mall()->where('user_id', $user->id)->first();
            $coupons = $coupons->checkVendor($store->id);
        }
        $coupons = $coupons->filter($request)->paginate($request->per_page ?? $this->limit);

        return $coupons;
    }


    public function search($request)
    {
        return Coupon::mall()->search($request->search)->paginate($request->per_page ?? $this->limit);
    }

    public function coupon($request)
    {
        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'), 'coupons');
        }

        // if current user is vendor attach the store_id for the coupon
        if ($request->user()->role_id == 3) {
            $data['store_id'] = $request->user()->store->id;
        }

        $data['app'] = 'mall';
        unset($data['_token']);
        $coupon = Coupon::create($data);

        if ($request->has('images')) {
            foreach ($request->images as $image) {
                $coupon->images()->create([
                    'path' => $this->uploadImage($image, 'coupons')
                ]);
            }
        }

        return $coupon;
    }


    public function update($request, $coupon)
    {
        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'), 'coupons', $coupon->image);
        }


        if ($request->has('images')) {
            foreach ($request->images as $image) {
                $coupon->images()->create([
                    'path' => $this->uploadImage($image, 'coupons')
                ]);
            }
        }

        if (!$request->has('delivery_type')) {
            $coupon->update(['delivery_type' => 0]);
        }

        if (!$request->has('pick_up')) {
            $coupon->update(['pick_up' => 0]);
        }
        unset($data['_token'], $data['_method']);
        $coupon->update($data);

        return $coupon;
    }


    public function delete($coupon)
    {
        $coupon->delete();
        return true;
    }

    public function deleteSelection($request)
    {
        $ids = explode(',', $request->ids);
        Coupon::whereIn('id', $ids)->delete();
        return true;
    }
}
