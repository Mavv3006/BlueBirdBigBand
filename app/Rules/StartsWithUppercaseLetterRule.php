<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class StartsWithUppercaseLetterRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $firstLetter = substr($value, 0, 1);
        if (strtoupper($firstLetter) !== $firstLetter) {
            $fail('The first letter of :attribute must be uppercase.');
        }
    }
}
