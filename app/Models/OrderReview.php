<?php

namespace App\Models;

use App\Traits\AppScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderReview extends Model
{
    use HasFactory, AppScope, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
