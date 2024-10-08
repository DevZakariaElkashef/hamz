<?php

namespace App\Models;

use App\Traits\AppScope;
use App\Traits\FilterScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, AppScope, FilterScope, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getPaymentMethodAttribute()
    {
        return $this->attributes['payment_type'] ? __('mall.wallet') : __('mall.online');
    }

    public function getPaymentConditionAttribute()
    {
        switch ($this->attributes['payment_type']) {
            case 0:
                return __("mall.pending");
                break;
            case 1:
                return __("mall.paid");
                break;
            case 2:
                return __("mall.faild");
                break;
            default:
                return __("mall.unknown");
                break;
        }
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('sub_total', 'like', "%$search%")
            ->orWhere('tax', 'like', "%$search%")
            ->orWhere('discount', 'like', "%$search%")
            ->orWhere('total', 'like', "%$search%")
            ->orWhere('address', 'like', "%$search%")
            ->orWhere('transaction_id', 'like', "%$search%")
            ->orWhere('delivery', 'like', "%$search%")
            ->orWhereHas('store', function ($store) use ($search) {
                $store->where("name_ar", 'like', "%$search%")
                    ->orWhere('name_en', 'like', "%$search%");
            });
    }



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function orderReview()
    {
        return $this->hasOne(OrderReview::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
