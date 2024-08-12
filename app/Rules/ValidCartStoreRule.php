<?php

namespace App\Rules;

use App\Models\Cart;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidCartStoreRule implements ValidationRule
{
    public $user;

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
        if (!checkUniqueStore($this->user, $value)) {
            $fail(__("mall.only_one_store"));
        }
    }
}
