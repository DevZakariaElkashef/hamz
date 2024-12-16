<?php

namespace App\Models;

use App\Traits\AppScope;
use App\Traits\ActiveScope;
use App\Traits\FilterScope;
use App\Traits\ImageAttribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slider extends Model
{
    use HasFactory, AppScope, ActiveScope, FilterScope, ImageAttribute, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getNameAttribute()
    {
        return $this->attributes['name_' . app()->getLocale()];
    }

    public function getName()
    {
        return $this->attributes['name_'.app()->getLocale()];
    }

    public function scopeFixed($query)
    {
        return $query->where('is_fixed', 1);
    }

    public function scopeScrollable($query)
    {
        return $query->where('is_fixed', 0);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name_ar', 'like', "%$search%")
                ->orWhere('name_en', 'like', "%$search%")
                ->orWhere('url', 'like', "%$search%");
    }
}
