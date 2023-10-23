<?php

namespace App\Http\Requests\Admin\Movie;

class UpdateMovieRequest extends StoreMovieRequest
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'thumbnail' => ['nullable', 'image'],
            'banner.image' => ['nullable', 'image'],
            'banner.description' => ['nullable', 'string', 'min:30', 'max:255'],
            'banner.fact' => ['nullable', 'string', 'min:3', 'max:255'],
        ]);
    }
}
