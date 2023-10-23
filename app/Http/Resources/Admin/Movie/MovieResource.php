<?php

namespace App\Http\Resources\Admin\Movie;

use App\Http\Resources\Admin\MovieBanner\MovieBannerResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
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
            'original_title' => $this->original_title,
            'slug' => $this->slug,
            'description' => $this->description,
            'priority' => $this->priority,
            'duration_in_minutes' => $this->duration_in_minutes,
            'age_restriction' => $this->age_restriction,
            'thumbnail' => $this->thumbnail_path,
            'release_year' => $this->release_year,
            'director' => $this->director,
            'production_country' => $this->production_country,
            'studio' => $this->studio,
            'main_cast' => $this->main_cast,
            'start_showing' => $this->start_showing->format('Y-m-d'),
            'end_showing' => $this->end_showing->format('Y-m-d'),
            'genres' => $this->genres->pluck('id'),
            'banner' => $this->banner()->exists() ? MovieBannerResource::make($this->banner)->resolve() : null
        ];
    }
}
