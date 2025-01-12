<?php

namespace App\Models;

use App\Traits\CheckVendorScope;
use Carbon\Carbon;
use App\Traits\AppScope;
use App\Traits\ActiveScope;
use App\Traits\FilterScope;
use App\Traits\ImageAttribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, AppScope, CheckVendorScope, ActiveScope, FilterScope, ImageAttribute, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getNameAttribute()
    {
        return $this->attributes['name_' . app()->getLocale()];
    }

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('Y-m-d');
    }

    public function title()
    {
        return $this->attributes['name_' . app()->getLocale()];
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name_ar', 'like', "%$search%")
            ->orWhere('name_en', 'like', "%$search%")
            ->orWhereHas('store', function ($store) use ($search) {
                $store->where('name_ar', 'like', "%$search%")
                    ->orWhere('name_ar', 'like', "%$search%");
            });
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function coupons()
    {
        return $this->hasMany(Coupon::class);
    }

    public function markas()
    {
        return $this->hasMany(Marka::class, 'category_id');
    }

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class, 'category_id');
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }
}
