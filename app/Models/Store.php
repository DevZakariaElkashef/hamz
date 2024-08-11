<?php

namespace App\Models;

use App\Traits\ActiveScope;
use App\Traits\AppScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use HasFactory, AppScope, ActiveScope, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getNameAttribute()
    {
        return $this->attributes['name_' . app()->getLocale()];
    }

    public function user()
    {
        return $this->belongsTo(User::class)->where('role_id', 3);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function brands()
    {
        return $this->hasMany(Brand::class);
    }

    public function products()
    {
        return $this->hasManyThrough(
            Product::class,      // The final model you want to access
            Category::class,     // The intermediate model
            'store_id',          // Foreign key on the Category model
            'category_id',       // Foreign key on the Product model
            'id',                // Local key on the Store model
            'id'                 // Local key on the Category model
        );
    }


    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
