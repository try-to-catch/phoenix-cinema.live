<?php

namespace App\Http\Resources\Screening;

use App\Http\Resources\Hall\HallResource;
use App\Http\Resources\Movie\MovieDetailsResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ScreeningInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this['id'],
            'start_time' => $this['start_time']->format('H:i'),
            'end_time' => $this['end_time']->format('H:i'),
            'start_date' => $this['start_time']->format('d.m.Y'),
            'start_date_day_of_weak' => Str::ucfirst($this['start_time']->isoFormat('dddd')),
            'standard_seat_price' => $this['standard_seat_price'],
            'premium_seat_price' => $this['premium_seat_price'],
            'hall' => HallResource::make($this['hall'])->resolve(),
            'movie' => MovieDetailsResource::make($this['movie'])->resolve(),
        ];
    }
}
