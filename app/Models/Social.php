<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\AppScope;
use App\Traits\FilterScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Social extends Model
{
    use HasFactory, FilterScope, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('Y-m-d');
    }
}
