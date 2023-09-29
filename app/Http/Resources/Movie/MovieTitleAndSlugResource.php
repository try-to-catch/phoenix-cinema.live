<?php

namespace App\Http\Resources\Movie;

use Illuminate\Http\Request;

class MovieTitleAndSlugResource extends MovieTitleResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array_merge(parent::toArray($request), [
            'slug' => $this->slug,
        ]);
    }
}
