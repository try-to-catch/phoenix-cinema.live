<?php

namespace App\Actions\Hall;

use App\Models\Hall;
use App\Models\HallTemplate;

/**
 * This action is used to create a hall based on a hall template instance
 */
class CreateHallAction
{
    public function handle(HallTemplate $template): Hall
    {
        $seats = $template->seats()->get(['seat_number', 'row_number', 'type'])->toArray();

        /** @var Hall $hall */
        $hall = Hall::query()->create(['title' => $template->title]);

        $hall->seats()->createMany($seats);

        return $hall;
    }
}
