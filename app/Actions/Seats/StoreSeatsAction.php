<?php

namespace App\Actions\Seats;

use App\Models\Hall;

/**
 * This action is used to store seats in the hall in the correct format.
 */
class StoreSeatsAction
{
    public function handle(Hall $hall, array $seats): void
    {
        $preparedSeats = [];

        foreach ($seats as $rowIndex => $row) {
            foreach ($row as $seatIndex => $seatData) {
                $seat = [
                    'seat_number' => $seatIndex + 1,
                    'row_number' => $rowIndex + 1,
                    'type' => $seatData['type'],
                ];

                $preparedSeats[] = $seat;
            }
        }

        $hall->seats()->createMany($preparedSeats);
    }
}
