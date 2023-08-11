<?php

namespace App\Actions\Screening;

use Illuminate\Database\Eloquent\Collection;

/**
 * Organize screenings by date and time.
 */
class OrganizeScreeningsAction
{
    public function handle(Collection $screenings)
    {
        $screenings = $screenings->sortBy('start_time')->groupBy(function ($screening) {
            return $screening->start_time->isoFormat('D MMMM');
        });

        return $screenings->map(function ($screening, $key) {

            $screenings = $screening->map(function ($screening) {
                return [
                    'start_time' => $screening->start_time,
                    'id' => $screening->id,
                ];
            });

            if ($key === now()->isoFormat('D MMMM')) {
                $key = 'Сьогодні';
            } elseif ($key === now()->addDay()->isoFormat('D MMMM')) {
                $key = 'Завтра';
            }

            return [
                'date' => $key,
                'screenings' => $screenings,
            ];
        })->values();
    }
}
