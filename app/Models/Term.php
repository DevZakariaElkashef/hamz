<?php

namespace App\Models;

use App\Traits\FilterScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Term extends Model
{
    use HasFactory, FilterScope, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getItemAttribute()
    {
        return $this->attributes['item_' . app()->getLocale()];
    }

    public function value()
    {
        return $this->attributes['item_' . app()->getLocale()];
    }
}
