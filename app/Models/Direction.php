<?php

namespace App\Models;

use App\Traits\AppScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Direction extends Model
{
    use HasFactory, AppScope, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function name()
    {
        return $this->attributes['name_' . app()->getLocale()];
    }


    public function products()
    {
        return $this->hasMany(Product::class, 'direction_id');
    }
}
