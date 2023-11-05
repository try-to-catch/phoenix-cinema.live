<?php

namespace App\Http\Resources\MovieScreenings;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieScreeningsListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'slug' => $this->slug,
            'title' => $this->title,
            'thumbnail' => $this->thumbnail_path,
            'duration_in_minutes' => $this->duration_in_minutes,
            'screenings_count' => $this->screenings_count,
        ];
    }
}
