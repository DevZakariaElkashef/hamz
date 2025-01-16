<?php

namespace App\Rules;

use App\Models\Withdrow;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class HasPendingWithdraw implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (
            Withdrow::where('user_id', auth()->user()->id)
            ->where('wallet_type', $value)
            ->where('status', '0')
            ->exists()
        ) {
            $fail(__('messages.pending_withdraw_exists'));
        }
    }
}
