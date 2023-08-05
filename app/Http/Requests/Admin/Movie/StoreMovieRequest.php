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
            'director' => ['required', 'string', 'max:255'],
            'production_country' => ['required', 'string', 'max:255'],
            'main_cast' => ['required', 'string', 'max:255'],
            'release_year' => ['nullable', 'date_format:Y'],
            'original_title' => ['nullable', 'string', 'max:255'],
            'studio' => ['nullable', 'string', 'max:255'],
            'start_showing' => ['nullable', 'date'],
            'end_showing' => ['nullable', 'date'],
            'banner' => ['nullable', 'array'],
            'banner.image' => ['nullable', 'image', 'required_with:banner_description,banner_fact'],
            'banner.description' => ['nullable', 'string', 'min:30', 'max:255', 'required_with:banner_image,banner_fact'],
            'banner.fact' => ['nullable', 'string', 'min:3', 'max:255', 'required_with:banner_image,banner_description'],
            'genres' => ['required', 'array'],
            'genres.*' => ['required', 'string', 'exists:genres,id'],
        ];
    }
}
