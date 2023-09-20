<?php

namespace App\Http\Resources\Screening;

use App\Http\Resources\Hall\HallDetailsResource;
use App\Http\Resources\Movie\MovieTitleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScreeningTicketInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'date' => $this['start_time']->isoFormat('DD MMMM YYYY'),
            'start_time' => $this['start_time']->format('H:i'),
            'end_time' => $this['end_time']->format('H:i'),
            'hall' => HallDetailsResource::make($this['hall'])->resolve(),
            'movie' => MovieTitleResource::make($this['movie'])->resolve(),
        ];
    }
}
