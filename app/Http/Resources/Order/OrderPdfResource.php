<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\Screening\ScreeningTicketInfoResource;
use App\Http\Resources\Seat\SeatPositionWithQRCodeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderPdfResource extends JsonResource
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
            'screening' => ScreeningTicketInfoResource::make($this['screening'])->resolve(),
            'seats' => SeatPositionWithQRCodeResource::collection($this['seats'])->resolve(),
        ];
    }
}
