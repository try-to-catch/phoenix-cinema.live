<?php

namespace App\Actions\Seat;

use App\Models\Seat;

class UpdateSeatsOrderIdAction
{
    /**
     * Update seats order id.
     */
    public function handle(array $seatIds, string $orderId): void
    {
        foreach ($seatIds as $seatId) {
            $seat = Seat::query()->find($seatId);
            $seat->order_id = $orderId;
            $seat->save();
        }
    }
}
