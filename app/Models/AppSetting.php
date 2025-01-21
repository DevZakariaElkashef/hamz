<?php

namespace App\Models;

use App\Traits\AppScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppSetting extends Model
{
    use HasFactory, AppScope, SoftDeletes;

    protected $table = 'app_settings';
    protected $fillable = [
        'key',
        'value_ar',
        'value_en',
    ];

    public function getContentAttribute()
    {
        return $this->attributes['value_' . app()->getLocale()];
    }
}
