<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\Screening\ScreeningTicketInfoResource;
use App\Http\Resources\Seat\SeatPositionWithQRCodeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class OrderPdfResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $qrCode = QrCode::format('png')->color(29, 32, 36)->style('round')->size(120)->generate(route('orders.check', ['order' => $this['id']]));

        return [
            'id' => $this['id'],
            'screening' => ScreeningTicketInfoResource::make($this['screening'])->resolve(),
            'seats' => SeatPositionWithQRCodeResource::collection($this['seats'])->resolve(),
            'qr_code' => base64_encode($qrCode),
        ];
    }
}
