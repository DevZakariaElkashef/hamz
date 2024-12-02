<?php

namespace App\Models;

use App\Traits\ActiveScope;
use App\Traits\AppScope;
use App\Traits\FilterScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory, ActiveScope, FilterScope, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];


    public function getNameAttribute()
    {
        return $this->attributes['name_' . app()->getLocale()];
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name_ar', 'like', "%$search%")
                ->orWhere('name_en', 'like', "%$search%");
    }

    public function title()
    {
        return $this->attributes['name_' . app()->getLocale()];
    }
}
