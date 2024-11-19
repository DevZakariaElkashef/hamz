<?php

namespace App\Models;

use App\Traits\AppScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory, AppScope;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    public function getName()
    {
        return $this->attributes['name_' . app()->getLocale()];
    }
}
