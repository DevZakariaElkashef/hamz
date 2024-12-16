<?php

namespace App\Models;

use App\Traits\AppScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductStatus extends Model
{
    use HasFactory, AppScope, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function title()
    {
        return $this->attributes['name_' . app()->getLocale()];
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'product_status_id');
    }
}
