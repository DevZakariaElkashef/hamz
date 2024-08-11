<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidPhoneNumber implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Define the regular expression for the phone number format
        $pattern = '/^0\d{9}$/'; // Matches a number starting with '0' and followed by exactly 9 digits

        if (!preg_match($pattern, $value)) {
            $fail(__('mall.invalid_phone_format'));
        }
    }
}
