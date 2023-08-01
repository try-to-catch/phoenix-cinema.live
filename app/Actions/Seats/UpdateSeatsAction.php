<?php

namespace App\Actions\Seats;

use App\Models\HallTemplate;

/**
 * This action is used to store seats in the hall in the correct format.
 */
class UpdateSeatsAction
{
    public function handle(HallTemplate $hall, array $updatedSeats): void
    {
        foreach ($updatedSeats as $updatedSeatData) {
            $seatId = $updatedSeatData['id'];
            $hall->seats()->updateOrCreate(['id' => $seatId], [
                'type' => $updatedSeatData['type'],
            ]);
        }

    }
}
