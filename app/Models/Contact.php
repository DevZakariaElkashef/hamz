<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\AppScope;
use App\Traits\FilterScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory, FilterScope, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function scopeSearch($query, $search)
    {
        return $query->with('contactType')->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('phone', 'like', "%$search%")
                ->orWhere('message', 'like', "%$search%")
                ->orWhereHas('contactType', function($store) use($search) {
                    $store->where('name_ar', 'like', "%$search%")
                    ->orWhere('name_ar', 'like', "%$search%");
                });
    }

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('Y-m-d');
    }

    public function contactType()
    {
        return $this->belongsTo(ContactType::class);
    }
}
