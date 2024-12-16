<?php

namespace App\Models;

use App\Traits\AppScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasFactory, AppScope, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function title()
    {
        return $this->attributes['title_' . app()->getLocale()];
    }
    public function message()
    {
        return $this->attributes['message_' . app()->getLocale()];
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function getTitleAttribute()
    {
        return $this->attributes['title_' . app()->getLocale()];
    }
    public function getMessageAttribute()
    {
        return $this->attributes['message_' . app()->getLocale()];
    }
}
