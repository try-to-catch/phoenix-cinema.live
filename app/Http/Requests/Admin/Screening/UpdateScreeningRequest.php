<?php

namespace App\Http\Requests\Admin\Screening;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateScreeningRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'start_time' => ['date', 'after:now'],
            'end_time' => ['date', 'after:start_time'],
            'standard_seat_price' => ['numeric', 'min:0'],
            'premium_seat_price' => ['numeric', 'min:0'],
        ];
    }
}
