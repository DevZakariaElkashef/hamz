<?php

namespace App\Models;

use App\Traits\ActiveScope;
use App\Traits\AppScope;
use App\Traits\CheckVendorScope;
use App\Traits\FilterScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory, AppScope, CheckVendorScope, FilterScope, ActiveScope, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];


    public function scopeSearch($query, $search)
    {
        $query->where('code', 'like', "%$search%")
            ->orWhere('max_usage', 'like', "%$search%")
            ->orWhere('start_date', 'like', "%$search%")
            ->orWhere('end_date', 'like', "%$search%")
            ->orWhere('discount', 'like', "%$search%");
    }

    public function users()
    {
        return $this->hasMany(UserCoupon::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
