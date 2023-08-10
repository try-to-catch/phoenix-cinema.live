<?php

namespace App\Http\Resources\Screening;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizedScreeningListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'date' => $this['date'],
            'screenings' => ScreeningMinResource::collection($this['screenings'])->resolve(),
        ];
    }
}
