<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Log;
use Illuminate\Translation\PotentiallyTranslatedString;

class AvailableUser implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param Closure(string):PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        User::where('name', $value)->firstOr(function () use ($fail, $value) {
            Log::debug('Validating the existence of user "'.$value.'" failed. No user with that name found.');
            $fail('No user with that :attribute found.');
        });
    }
}
