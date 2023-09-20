<?php

namespace App\Http\Resources\Seat;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SeatPositionWithQRCodeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $qrCode = QrCode::format('png')->color(29, 32, 36)->style('round')->size(120)->generate(route('orders.seats.check', ['seat' => $this['id'], 'order' => $this['order_id']]));

        return [
            'id' => $this['id'],
            'seat_number' => $this['seat_number'],
            'row_number' => $this['row_number'],
            'qr_code' => base64_encode($qrCode),
        ];
    }
}
