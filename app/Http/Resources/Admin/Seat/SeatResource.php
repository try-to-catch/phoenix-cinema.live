<?php

namespace App\Http\Resources\Admin\Seat;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $seats = $this->resource->sortBy('row_number, seat_number');
        $preparedSeats = [];

        foreach ($seats as $seat) {
            $preparedSeats[$seat->row_number][$seat->seat_number] = [
                'id' => $seat->id,
                'type' => $seat->type,
                'row_number' => $seat->row_number,
                'seat_number' => $seat->seat_number,
            ];
        }

        return $preparedSeats;
    }
}
