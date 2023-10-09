<?php

namespace App\Http\Requests\Order;

use App\Rules\SeatAvailableRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    protected $stopOnFirstFailure = false;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        return [
            'seat_ids' => ['required', 'array', new SeatAvailableRule],
            'seat_ids.*' => ['required', 'string', 'exists:seats,id'],
            'card_data' => ['required', 'array'],
            'card_data.card_number' => ['required', 'string', 'size:16'],
            'card_data.expire_month' => ['required', 'integer', 'min:1', 'max:12',
                function ($attribute, $value, $fail) use ($currentMonth, $currentYear) {
                    if ($value < $currentMonth && $this->input('card_data.expire_year') === $currentYear) {
                        $fail($attribute . ' has already passed for the current year.');
                    }
                }],
            'card_data.expire_year' => ['required', 'integer', 'min:' . $currentYear, 'max:' . $currentYear + 10],
            'card_data.cvv_code' => ['required', 'string'],
        ];
    }
}
