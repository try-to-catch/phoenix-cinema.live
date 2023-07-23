<?php

namespace App\Http\Requests\Admin\Movie;

use App\Models\Movie;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreMovieRequest extends FormRequest
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
            'description' => ['required', 'string'],
            'priority' => ['required', 'integer', 'between:1,100'],
            'duration_in_minutes' => ['required', 'integer', 'min:1'],
            'age_restriction' => ['required', 'string', 'in:' . implode(',', Movie::AGE_RESTRICTIONS)],
            'thumbnail' => ['required', 'image'],
            'release_year' => ['nullable', 'date_format:Y'],
            'original_title' => ['nullable', 'string', 'max:255'],
            'production_country' => ['nullable', 'string', 'max:255'],
            'studio' => ['nullable', 'string', 'max:255'],
            'main_cast' => ['nullable', 'string', 'max:255'],
            'start_showing' => ['nullable', 'date'],
            'end_showing' => ['nullable', 'date'],
            'genres' => ['required', 'array'],
            'genres.*' => ['required', 'string', 'exists:genres,id'],
        ];
    }
}
