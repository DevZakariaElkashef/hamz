<?php

namespace App\Models;

use App\Traits\AppScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commenets extends Model
{
    use HasFactory, AppScope, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    public function getNameAttribute()
    {
        return $this->attributes['name_' . app()->getLocale()];
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
