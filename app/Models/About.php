<?php

namespace App\Models;

use App\Traits\AppScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class About extends Model
{
    use HasFactory, AppScope, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function value()
    {
        return $this->attributes['content_' . app()->getLocale()];
    }
}
