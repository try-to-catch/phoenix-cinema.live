<?php

namespace App\Actions\Movies;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class GetFutureMoviesAction
{
    public function handle(array $columns, int $count = null): Collection
    {
        return Cache::remember('movies:screening_in_future', 60 * 60,
            function () use ($columns, $count) {
                $query = Movie::screeningSoonWithGenres()->orderBy('start_showing');

                if (is_null($count)) {
                    return $query->get($columns);
                }

                return $query->take($count)->get($columns);
            });
    }
}
