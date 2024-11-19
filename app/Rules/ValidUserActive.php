<?php

namespace App\Rules;

use Closure;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidUserActive implements ValidationRule
{
    protected $phone;

    public function __construct($phone)
    {
        $this->phone = $phone;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $user = User::where('phone', $this->phone)->first();

        if (!$user || !$user->is_active) {
            $fail(__('main.plz_active_your_account'));
        }
    }
}
