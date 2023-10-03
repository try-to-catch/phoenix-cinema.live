<?php

namespace App\Http\Resources\Seat;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeatPositionWithQRCodeResource extends JsonResource
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
            'seat_number' => $this['seat_number'],
            'row_number' => $this['row_number'],

        ];
    }
}
