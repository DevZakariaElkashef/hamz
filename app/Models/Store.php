<?php

namespace App\Models;

use App\Traits\ActiveScope;
use App\Traits\AppScope;
use App\Traits\FilterScope;
use App\Traits\ImageAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
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
                ->orWhere('description_ar', 'like', "%$search%")
                ->orWhere('description_en', 'like', "%$search%")
                ->orWhere('address', 'like', "%$search%")
                ->orWhere('lat', 'like', "%$search%")
                ->orWhere('lng', 'like', "%$search%")
                ->orWhere('id', 'like', "%$search%")
                ->orWhereHas('user', function($user) use($search) {
                    $user->where("name", "LIKE", "%$search%")
                    ->orWhere("email", "LIKE", "%$search%")
                    ->orWhere("phone", "LIKE", "%$search%");
                })
                ->orWhereHas('section', function($user) use($search) {
                    $user->where("name_ar", "LIKE", "%$search%")
                    ->orWhere("name_en", "LIKE", "%$search%");
                });
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

    public function storeDelivery()
    {
        return $this->hasOne(StoreDelivery::class);
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


    public function calcDeliveryValue($userLocation)
    {
        $delivery = 0;
        $status = true;

        // Check if the store has delivery type and storeDelivery relationship
        if ($this->delivery_type && $this->storeDelivery) {
            $storeDelivery = $this->storeDelivery;

            if ($storeDelivery->default_type) {
                // Calculate distance
                $distance = distance($this->lat, $this->lng, $userLocation['lat'], $userLocation['lng']);


                // Handle free delivery distance
                $freeDeliveryDistance = $storeDelivery->free_delivery_distance ?? 0;
                $maxDistance = $storeDelivery->max_distance ?? PHP_INT_MAX;

                if ($distance > $freeDeliveryDistance && $distance < $maxDistance) {
                    $costPerKm = $storeDelivery->cost_per_km ?? 0;
                    $delivery = $distance * $costPerKm;
                } elseif ($distance > $maxDistance) {
                    // Not working area; set status to false
                    $status = false;
                }
            } else {
                // Handle fixed delivery value
                $delivery = $storeDelivery->fixed_value ?? 0;
            }
        }

        return [
            'status' => $status,
            'delivery' => $delivery
        ];
    }
}
