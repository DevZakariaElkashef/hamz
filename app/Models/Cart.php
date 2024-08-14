<?php

namespace App\Models;

use App\Traits\AppScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasFactory, AppScope, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function calcSubTotal()
    {
        $sum = 0;
        if ($this && $this->items->count()) {
            foreach ($this->items as $item) {
                $sum += ($item->qty * $item->product->calc_price);
            }
        }

        return $sum;
    }

    public function calcTax()
    {
        $subtotal = $this->calcSubTotal();

        return $subtotal * .15;
    }

    public function calcDiscount()
    {
        $subtotal = $this->calcSubTotal();
        $tax = $this->calcTax();
        $delivery = $this->delivery ?? 0;
        $discount = $this->coupon ? $this->coupon->discount : 0;

        return ($subtotal + $tax + $delivery) * ($discount / 100);
    }

    public function calcTotal()
    {
        $subtotal = $this->calcSubTotal();
        $tax = $this->calcTax();
        $delivery = $this->delivery ?? 0;
        $discount = $this->calcDiscount();

        return ($subtotal + $tax + $delivery) - $discount;
    }
}
