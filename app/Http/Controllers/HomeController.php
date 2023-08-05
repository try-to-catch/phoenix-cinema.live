<?php

namespace App\Http\Controllers;

use App\Http\Resources\MovieBanner\MovieBannerResource;
use App\Models\Movie;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function __invoke()
    {
        $movieWithBanner = Movie::hasBanner()->inRandomOrder()->take(1)->with(['banner', 'genres'])->first();
        return Inertia::render('Home', [
            'banner' => MovieBannerResource::make($movieWithBanner),
        ]);
    }
}
