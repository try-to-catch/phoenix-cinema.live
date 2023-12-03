<?php

namespace App\Actions\Movies;

use App\Models\Movie;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * Organize screenings by date and time.
 */
class GetOrganizedMovieScreeningsAction
{
    public function handle(Movie $movie): Collection
    {
        return Cache::remember("movies:{$movie['id']}:organized_screenings", 60 * 15, function () use ($movie) {

            $movie->load('screenings');
            $screenings = $movie->screenings()->notOver()->sortBy('start_time')->groupBy(function ($screening) {
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
        });
    }
}
