<?php

namespace App\Models;

use App\Traits\ActiveScope;
use App\Traits\AppScope;
use App\Traits\FilterScope;
use App\Traits\ImageAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, AppScope, ActiveScope, FilterScope, ImageAttribute, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getNameAttribute()
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
}
