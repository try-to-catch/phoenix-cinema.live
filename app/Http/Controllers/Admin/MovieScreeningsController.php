<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Movies\GetOrganizedMovieScreeningsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MovieScreenings\MovieScreeningsListRequest;
use App\Http\Resources\MovieScreenings\MovieScreeningsListResource;
use App\Http\Resources\Screening\OrganizedScreeningListResource;
use App\Models\Movie;
use Inertia\Inertia;
use Inertia\Response;

class MovieScreeningsController extends Controller
{
    public function index(MovieScreeningsListRequest $request): Response
    {
        $screenings = Movie::query()
            ->searched($data['s'] ?? '')
            ->select('slug', 'title', 'thumbnail', 'duration_in_minutes', 'updated_at')
            ->withCount('screenings')
            ->latest('updated_at')
            ->paginate(10);

        return Inertia::render('Admin/Movies/Screenings/Index', [
            'movieScreenings' => MovieScreeningsListResource::collection($screenings),
        ]);
    }

    public function show(Movie $movie, GetOrganizedMovieScreeningsAction $getOrganizedMovieScreeningsAction): Response
    {
        $screenings = $getOrganizedMovieScreeningsAction->handle($movie);

        return Inertia::render('Admin/Movies/Screenings/Show', [
            'screenings' => OrganizedScreeningListResource::collection($screenings)->resolve(),
        ]);
    }
}
