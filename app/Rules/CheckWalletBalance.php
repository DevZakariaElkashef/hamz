<?php

namespace App\Rules;

use App\Models\Cart;
use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckWalletBalance implements ValidationRule
{
    private $cart_id;

    public function __construct($cart_id)
    {
        $this->cart_id = $cart_id;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value == 1) {
            $balance = User::select('wallet')->where('id', auth()->id())->first()->wallet;
            $cart = Cart::find($this->cart_id);
            if($cart) {
                $total_price = $cart->calcTotal();
                if ($balance < $total_price) {
                    $fail(__('messages.insufficient_balance_wallet'));
                }
            }
        }
    }
}
