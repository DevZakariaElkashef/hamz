<?php

namespace App\Models;

use App\Traits\AppScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelTypes extends Model
{
    use HasFactory, AppScope, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function products()
    {
        return $this->hasMany(Product::class, 'model_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }
    public function title()
    {
        return $this->attributes['name_' . app()->getLocale()];
    }
}
