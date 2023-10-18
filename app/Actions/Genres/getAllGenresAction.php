<?php

namespace App\Actions\Genres;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class getAllGenresAction
{
    public function handle(): Collection
    {
        return Cache::remember('genres:all', 60 * 60, fn () => Genre::all('id', 'name'));
    }
}
