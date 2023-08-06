<?php

namespace App\Http\Resources\MovieBanner;

use App\Http\Resources\Genre\GenreResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieBannerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        Carbon::setLocale(config('app.locale'));

        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'start_showing' => $this->start_showing->isoFormat('D MMMM'),
            'end_showing' => $this->end_showing->isoFormat('D MMMM'),
            'duration' => $this->formattedDuration,
            'main_cast' => $this->main_cast,
            'production_country' => $this->production_country,
            'image' => $this->banner->image_path,
            'description' => $this->banner->description,
            'fact' => $this->banner->fact,
            'genres' => GenreResource::collection($this->genres)->resolve(),
        ];
    }
}
