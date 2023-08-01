<?php

namespace App\Http\Requests\Admin\Screening;

use App\Models\HallTemplate;
use App\Models\Movie;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreScreeningRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'movie_id' => ['required', 'string', 'exists:' . Movie::class . ',id'],
            'hall_template_id' => ['required', 'string', 'exists:' . HallTemplate::class . ',id'],
            'start_time' => ['required', 'date_format:Y-m-d\TH:i'],
            'end_time' => ['required', 'date_format:Y-m-d\TH:i'],
            'standard_seat_price' => ['required', 'numeric', 'min:0'],
            'premium_seat_price' => ['required', 'numeric', 'min:0'],
        ];
    }
}
