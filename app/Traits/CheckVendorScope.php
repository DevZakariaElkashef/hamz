<?php

namespace App\Traits;

trait CheckVendorScope
{
    public function scopeCheckVendor($query, $store_id)
    {
        if (auth()->user()->role_id == 3) {
            return $query->where('store_id', $store_id);
        }

        return $query;
    }
}
