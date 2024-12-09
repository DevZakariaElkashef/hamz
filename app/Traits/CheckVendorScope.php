<?php

namespace App\Traits;

trait CheckVendorScope
{
    public function scopeCheckVendor($query, $user)
    {
        if ($user->role_id == 3) {
            return $query->where('store_id', $user->store->id);
        }

        return $query;
    }
}
