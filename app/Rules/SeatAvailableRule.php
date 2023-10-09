<?php

namespace App\Rules;

use App\Models\Seat;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class SeatAvailableRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (Seat::whereIn('id', $value)->whereNull('order_id')->count() !== count($value)) {
            $fail('Одне або кілька місць вже зайнято. Будь ласка, оновіть сторінку.');
        }
    }
}
