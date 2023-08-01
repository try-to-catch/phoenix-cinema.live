<?php

namespace App\Actions\Seats;

use App\Models\Hall;
use App\Models\HallTemplate;

/**
 * This action is used to store seats in the hall in the correct format.
 * If no seats are provided, it will use the default seats template.
 */
class StoreSeatsAction
{
    protected array $seats = [
        [
            ['type' => 'standard'], ['type' => 'standard'], ['type' => 'standard'], ['type' => 'standard']
        ],
        [
            ['type' => 'standard'], ['type' => 'standard'], ['type' => 'standard'], ['type' => 'standard'],
        ],
        [
            ['type' => 'premium'], ['type' => 'premium'], ['type' => 'premium'], ['type' => 'premium'],
        ]
    ];

    public function handle(HallTemplate|Hall $hall, array $seats = []): void
    {
        $seats = empty($seats) ? $this->seats : $seats;
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
