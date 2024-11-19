<?php

namespace App\Rules;

use Closure;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidUserPassword implements ValidationRule
{
    protected $phone;
    protected $password;

    public function __construct($phone, $password)
    {
        $this->phone = $phone;
        $this->password = $password;
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

        if (!$user || !Hash::check($this->password, $user->password)) {
            $fail(__('main.invalid_password'));
        }
    }
}
