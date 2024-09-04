<?php

namespace App\Models;

use App\Traits\ActiveScope;
use App\Traits\AppScope;
use App\Traits\FilterScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model
{
    use HasFactory, AppScope, ActiveScope, FilterScope, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getNameAttribute()
    {
        return $this->attributes['name_' . app()->getLocale()];
    }

    public function getOptionIdAttribute()
    {
        return $this->pivot->option_id;
    }

    public function getIsRequiredAttribute()
    {
        return $this->pivot->is_required;
    }

    public function getAdditionalPriceAttribute()
    {
        return $this->pivot->additional_price;
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_attribute_option')
            ->withPivot('option_id', 'is_required', 'additional_price')
            ->withTimestamps();
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }
}
