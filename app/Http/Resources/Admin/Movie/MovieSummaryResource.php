<?php

namespace App\Http\Resources\Admin\Movie;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieSummaryResource extends JsonResource
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
            'thumbnail' => $this->thumbnail_path,
        ];
    }
}
