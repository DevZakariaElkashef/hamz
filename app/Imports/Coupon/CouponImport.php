<?php

namespace App\Imports\Coupon;

use App\Models\Coupon;
use Maatwebsite\Excel\Concerns\ToModel;

class CouponImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Coupon([
            //
        ]);
    }
}
