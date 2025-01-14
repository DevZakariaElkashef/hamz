<?php

namespace App\Repositories\Coupon;

use App\Models\Coupon;
use App\Traits\ImageUploadTrait;
use Maatwebsite\Excel\Concerns\ToArray;

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
        $coupons = Coupon::when($request->user()->role_id == 3, function ($query) use ($request) {
            $query->where('user_id', $request->user()->id);
        })->filter($request)->coupon()->paginate($request->per_page ?? $this->limit);

        return $coupons;
    }


    public function search($request)
    {
        return Coupon::when($request->user()->role_id == 3, function ($query) use ($request) {
            $query->where('user_id', $request->user()->id);
        })->coupon()->search($request->search)->paginate($request->per_page ?? $this->limit);
    }

    public function coupon($request)
    {
        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'), 'coupons');
        }

        $data['app'] = 'coupons';
        $data['user_id'] = $request->user()->id;
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
        $data = $request->toArray();
        $coupon->update($data);
        // $data = $request->except('image');

        // if ($request->hasFile('image')) {
        //     $data['image'] = $this->uploadImage($request->file('image'), 'coupons', $coupon->image);
        // }


        // if ($request->has('images')) {
        //     foreach ($request->images as $image) {
        //         $coupon->images()->create([
        //             'path' => $this->uploadImage($image, 'coupons')
        //         ]);
        //     }
        // }

        // if (!$request->has('delivery_type')) {
        //     $coupon->update(['delivery_type' => 0]);
        // }

        // if (!$request->has('pick_up')) {
        //     $coupon->update(['pick_up' => 0]);
        // }
        // unset($data['_token'], $data['_method']);
        // $coupon->update($data);

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
