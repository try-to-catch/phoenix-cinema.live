<?php

namespace App\Http\Resources\Admin\MovieBanner;

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
        return [
            'id' => $this->id,
            'image' => $this->image_path,
            'description' => $this->description,
            'fact' => $this->fact,
        ];
    }
}
