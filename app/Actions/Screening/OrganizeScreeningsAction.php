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
            return $screening->start_time->format('d-m-Y');
        });

        return $screenings->map(function ($screening, $key) {

            $screenings = $screening->map(function ($screening) {
                return [
                    'start_time' => $screening->start_time,
                    'id' => $screening->id,
                ];
            });

            if ($key === now()->format('d-m-Y')) {
                $key = 'Today';
            } elseif ($key === now()->addDay()->format('d-m-Y')) {
                $key = 'Tomorrow';
            }

            return [
                'date' => $key,
                'screenings' => $screenings,
            ];
        })->values();
    }
}
