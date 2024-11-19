<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidUserWallet implements ValidationRule
{
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $wallet = $this->user->wallet;
        if (!$wallet) {
            $fail(__("main.walletr_is_empty"));
        }

        if ($wallet < $value) {
            $fail(__("main.you_dont_have_enough_money"));
        }
    }
}
