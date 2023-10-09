<?php

namespace App\Actions\Movies;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class GetCurrentScreeningMoviesAction
{
    public function handle(array $columns, ?int $count = null): Collection
    {
        return Cache::remember('movies:current_screening', 60 * 60,
            function () use ($columns, $count) {
                $query = Movie::currentlyScreeningWithGenres()->orderByDesc('priority');

                if (is_null($count)) {
                    return $query->get($columns);
                }

                return $query->take($count)->get($columns);
            });
    }
}
