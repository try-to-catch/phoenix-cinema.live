<?php

namespace App\Actions\Movies;

use App\Http\Resources\MovieBanner\MovieBannerResource;
use App\Models\Movie;

class GetMovieWithBannerResolvedAction
{
    public function handle(): ?array
    {
        $movieWithBanner = Movie::query()->hasBanner()->inRandomOrder()->with(['banner', 'genres'])->first();
        return $movieWithBanner ? MovieBannerResource::make($movieWithBanner)->resolve() : null;
    }
}
