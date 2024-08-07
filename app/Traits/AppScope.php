<?php

namespace App\Traits;

trait AppScope
{
    public function scopeMall($query)
    {
        return $query->where('app', 'mall');
    }

    public function scopeBooth($query)
    {
        return $query->where('app', 'booth');
    }

    public function scopeCoupons($query)
    {
        return $query->where('app', 'coupons');
    }

    public function scopeEarn($query)
    {
        return $query->where('app', 'earn');
    }

    public function scopeResale($query)
    {
        return $query->where('app', 'resale');
    }

    public function scopeRfoof($query)
    {
        return $query->where('app', 'rfoof');
    }

    public function scopeAllApps($query)
    {
        return $query->where('app', 'all');
    }
}
