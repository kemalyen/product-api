<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ValidationRule;

class ValidProductPrice implements ValidationRule
{
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        if ($value <= 0) {
            $fail('The :attribute must be positive.');
            return;
        }

        if (strpos((string) $value, '.') !== false) {
            $decimals = strlen(substr(strrchr((string) $value, '.'), 1));
            if ($decimals > 2) {
                $fail('The :attribute must have maximum 2 decimal places.');
                return;
            }
        }
    }
}
