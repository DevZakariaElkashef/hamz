<?php

namespace App\Traits;

trait AppScope
{
    public function scopeMall($query)
    {
        return $query->whereIn('app', ['mall']);
    }

    public function scopeBooth($query)
    {
        return $query->whereIn('app', ['booth']);
    }

    public function scopeCoupons($query)
    {
        return $query->whereIn('app', ['coupons']);
    }

    public function scopeEarn($query)
    {
        return $query->whereIn('app', ['earn']);
    }

    public function scopeResale($query)
    {
        return $query->whereIn('app', ['resale']);
    }

    public function scopeRfoof($query)
    {
        return $query->whereIn('app', ['rfoof']);
    }

    public function scopeAllApps($query)
    {
        return $query->where('app', 'all');
    }
}
