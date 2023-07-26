<?php

namespace App\Http\Resources\Admin\Hall;

use App\Http\Resources\Admin\Seat\SeatResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HallWithSeatsResource extends JsonResource
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
            'is_available' => $this->is_available,
            'seats' => SeatResource::make($this->seats)->resolve(),
        ];
    }
}
