<?php

namespace App\Rules;

use Closure;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidUserRole implements ValidationRule
{
    protected $phone;

    public function __construct($phone)
    {
        $this->phone = $phone;
    }

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $user = User::where('phone', $this->phone)->first();

        if (!$user || !in_array($user->role_id, [2, 3])) {
            $fail(__('main.invalid_role'));
        }
    }
}
