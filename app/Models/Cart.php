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

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function calcSubTotal($user)
    {
        $cart = $user->cart;
        $sum = 0;
        if ($cart && $cart->items->count()) {
            foreach ($cart->items as $item) {
                $sum += ($item->qty * $item->product->calc_price);
            }
        }

        return $sum;
    }

    public function calcTax($user)
    {
        $subtotal = $this->calcSubTotal($user);

        return $subtotal * .15;
    }

    public function calcDiscount($user)
    {
        $subtotal = $this->calcSubTotal($user);
        $tax = $this->calcTax($user);
        $delivery = $this->delivery ?? 0;
        $discount = $user->cart->coupon ? $user->cart->coupon->discount : 0;

        return ($subtotal + $tax + $delivery) * ($discount / 100);
    }

    public function calcTotal($user)
    {
        $subtotal = $this->calcSubTotal($user);
        $tax = $this->calcTax($user);
        $delivery = $this->delivery ?? 0;
        $discount = $this->calcDiscount($user);

        return ($subtotal + $tax + $delivery) - $discount;
    }
}
