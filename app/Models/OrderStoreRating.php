<?php

namespace App\Models;

use App\Traits\AppScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderStoreRating extends Model
{
    use HasFactory, AppScope, SoftDeletes;
    protected $table = 'order_store_rating';

    protected $fillable = [
        'rateable_id',
        'rateable_type',
        'rating',
        'app',
        'user_id',
        'comment'
    ];
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function rateable()
    {
        return $this->morphTo();
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
