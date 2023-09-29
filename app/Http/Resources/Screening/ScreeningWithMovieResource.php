<?php

namespace App\Http\Resources\Screening;

use App\Http\Resources\Movie\MovieTitleAndSlugResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScreeningWithMovieResource extends JsonResource
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
            'movie_id' => $this->movie_id,
            'start_time' => $this->start_time,
            'movie' => MovieTitleAndSlugResource::make($this->movie)->resolve(),
        ];
    }
}
