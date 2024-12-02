<?php

namespace App\Models;

use App\Traits\AppScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use HasFactory, AppScope, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function cities()
    {
        return $this->hasMany(City::class, 'country_id');
    }
    
    public function title()
    {
        return $this->attributes['name_' . app()->getLocale()];
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
