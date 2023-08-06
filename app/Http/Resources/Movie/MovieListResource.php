<?php

namespace App\Http\Resources\Movie;

use App\Http\Resources\Genre\GenreResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'thumbnail' => $this->thumbnail_path,
            'age_restriction' => $this->age_restriction,
            'director' => $this->director,
            'start_showing' => $this->start_showing->isoFormat('D MMMM'),
            'end_showing' => $this->end_showing->isoFormat('D MMMM'),
            'genres' => GenreResource::collection($this->genres)->resolve(),
        ];
    }
}
