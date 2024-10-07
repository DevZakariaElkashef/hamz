<?php

namespace App\Models;

use App\Traits\ActiveScope;
use App\Traits\AppScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use HasFactory, AppScope, ActiveScope, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];


    public function viewed()
    {
        return $this->hasMany(View::class);
    }
}
