<?php

namespace App\Http\Requests\Admin\HallTemplate;

use App\Models\Seat;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateHallTemplateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'number' => ['required', 'integer', 'min:1'],
            'address' => ['required', 'string', 'max:255'],
            'is_available' => ['required', 'boolean'],
            'seats' => ['required', 'array'],
            'seats.*' => ['nullable', 'array'],
            'seats.*.*.type' => ['required', 'string', Rule::in(Seat::SEAT_TYPES)],
        ];
    }
}
