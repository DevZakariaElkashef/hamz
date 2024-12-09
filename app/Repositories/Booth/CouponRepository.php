<?php

namespace App\Repositories\Booth;

use App\Models\Coupon;
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
        $coupons = Coupon::filter($request)->booth()->paginate($request->per_page ?? $this->limit);

        return $coupons;
    }


    public function search($request)
    {
        return Coupon::booth()->search($request->search)->paginate($request->per_page ?? $this->limit);
    }

    public function coupon($request)
    {
        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] =  $this->uploadImage($request->file('image'), 'coupons');
        }

        // if current user is vendor attach the store_id for the coupon
        if ($request->user()->role_id == 3) {
            if ($request->user()->store && $request->user()->store->id) {
                $data['store_id'] = $request->user()->store->id;
            }
        }

        $data['app'] = 'booth';
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
            $data['image'] =  $this->uploadImage($request->file('image'), 'coupons', $coupon->image);
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
