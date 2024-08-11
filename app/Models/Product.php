<?php

namespace App\Models;

use App\Traits\ActiveScope;
use App\Traits\AppScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, AppScope, ActiveScope, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getNameAttribute()
    {
        return $this->attributes['name_' . app()->getLocale()];
    }

    public function getDescriptionAttribute()
    {
        return $this->attributes['description_' . app()->getLocale()];
    }

    public function getCalcPriceAttribute()
    {
        $currentDate = now(); // Get the current date and time

        if ($this->offer && $this->start_offer_date && $this->end_offer_date) {
            // Check if the current date is within the offer period
            if ($currentDate->between($this->start_offer_date, $this->end_offer_date)) {
                return $this->offer; // Return the offer price if within the offer period
            }
        }

        return $this->price; // Return the regular price if no valid offer
    }

    public function getActiveOffer()
    {
        $currentDate = now(); // Get the current date and time

        if ($this->offer && $this->start_offer_date && $this->end_offer_date) {
            // Check if the current date is within the offer period
            if ($currentDate->between($this->start_offer_date, $this->end_offer_date)) {
                return $this->offer; // Return the offer price if within the offer period
            }
        }

        return 0; // Return null if no active offer
    }



    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function store()
    {
        return $this->hasOneThrough(
            Store::class,         // The final model you want to access
            Category::class,      // The intermediate model
            'id',                 // Foreign key on the Category model
            'id',                 // Foreign key on the Store model
            'category_id',        // Local key on the Product model
            'store_id'            // Local key on the Category model
        );
    }

    // Scope to filter products by section ID
    public function scopeInSection($query, $sectionId)
    {
        return $query->whereHas('store', function ($query) use ($sectionId) {
            $query->whereHas('section', function ($query) use ($sectionId) {
                $query->where('id', $sectionId);
            });
        });
    }

    public function productAttributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
