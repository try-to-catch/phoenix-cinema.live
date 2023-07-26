<?php

namespace App\Http\Requests\Admin\Hall;

use App\Models\Seat;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreHallRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'is_available' => ['boolean', 'max:255'],
            'seats' => ['required', 'array'],
            'seats.*' => ['required', 'array'],
            'seats.*.*' => ['required', 'array'],
            'seats.*.*.type' => ['required', 'string', 'in:' . implode(',', array_values(Seat::SEAT_TYPES))],
        ];
    }
}
