<?php

namespace App\Traits;

trait AppScope
{
    public function scopeMall($query)
    {
        return $query->whereIn('app', ['mall', 'all']);
    }

    public function scopeBooth($query)
    {
        return $query->whereIn('app', ['booth', 'all']);
    }

    public function scopeCoupons($query)
    {
        return $query->whereIn('app', ['coupons', 'all']);
    }

    public function scopeEarn($query)
    {
        return $query->whereIn('app', ['earn', 'all']);
    }

    public function scopeResale($query)
    {
        return $query->whereIn('app', ['resale', 'all']);
    }

    public function scopeRfoof($query)
    {
        return $query->whereIn('app', ['rfoof', 'all']);
    }

    public function scopeAllApps($query)
    {
        return $query->where('app', 'all');
    }
}
