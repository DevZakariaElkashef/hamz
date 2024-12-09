<?php

namespace App\Models;

use App\Traits\AppScope;
use App\Traits\CheckVendorScope;
use App\Traits\FilterScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Option extends Model
{
    use HasFactory, CheckVendorScope, AppScope, FilterScope, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getValueAttribute()
    {
        return $this->attributes['value_' . app()->getLocale()];
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_attribute_option')
                    ->withPivot('attribute_id', 'is_required', 'additional_price')
                    ->withTimestamps();
    }
}
