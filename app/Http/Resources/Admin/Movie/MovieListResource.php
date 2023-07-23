<?php

namespace App\Http\Resources\Admin\Movie;

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
            'duration_in_minutes' => $this->duration_in_minutes,
            'age_restriction' => $this->age_restriction,
            'thumbnail' => $this->thumbnail,
            'start_showing' => $this->start_showing->format('d-m-Y'),
            'end_showing' => $this->end_showing->format('d-m-Y'),
        ];
    }
}
