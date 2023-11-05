<?php

namespace App\Actions\Movies;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class GetMoviesAction
{
    public function handle(array $columns, $count = null, $orderCol = 'title'): Collection
    {
        $safeCount = $count ?? 'all';
        $parsedColumns = implode(',', $columns);
        return Cache::remember("movies:$parsedColumns:$safeCount", 60 * 60,
            function () use ($columns, $count, $orderCol) {
                $query = Movie::missingCompleted()->orderBy($orderCol);

                if (is_null($count)) {
                    return $query->get($columns);
                }

                return $query->take($count)->get($columns);
            });
    }
}
