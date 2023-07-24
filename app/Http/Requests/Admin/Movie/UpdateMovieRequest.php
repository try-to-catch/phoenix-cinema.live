<?php

namespace App\Http\Requests\Admin\Movie;

class UpdateMovieRequest extends StoreMovieRequest
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'thumbnail' => ['nullable', 'image'],
        ]);
    }
}
