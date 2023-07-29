<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Movie\StoreMovieRequest;
use App\Http\Requests\Admin\Movie\UpdateMovieRequest;
use App\Http\Resources\Admin\Genre\GenreResource;
use App\Http\Resources\Admin\Movie\MovieItemResource;
use App\Http\Resources\Admin\Movie\MovieListResource;
use App\Models\Genre;
use App\Models\Movie;
use App\Services\ThumbnailService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class MovieController extends Controller
{


    public function __construct(public ThumbnailService $thumbnailService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $movies = Movie::query()
            ->select([
                'id',
                'title',
                'slug',
                'duration_in_minutes',
                'age_restriction',
                'thumbnail',
                'start_showing',
                'end_showing',
            ])
            ->latest('updated_at')
            ->paginate();

        return Inertia::render('Admin/Movies/Index', [
            'movies' => MovieListResource::collection($movies),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Admin/Movies/Create', [
            'genres' => GenreResource::collection(Genre::all('id', 'name'))
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMovieRequest $request): RedirectResponse
    {
        $newMovie = $request->validated();
        $newMovie['thumbnail'] = $this->thumbnailService->store($newMovie['thumbnail'], 'movie');

        $movie = tap(
            Movie::query()->create($newMovie),
            fn(Movie $movie) => $movie->genres()->attach($newMovie['genres'])
        );

        return to_route('admin.movies.show', ['movie' => $movie->slug]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie): RedirectResponse
    {
        return to_route('admin.movies.edit', ['movie' => $movie->slug]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $movie): Response
    {
        return Inertia::render('Admin/Movies/Edit', [
            'movie' => new MovieItemResource($movie->load('genres')),
            'genres' => GenreResource::collection(Genre::all('id', 'name'))
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMovieRequest $request, Movie $movie): RedirectResponse
    {
        $newMovie = $request->validated();

        $newMovie['thumbnail'] = $this->thumbnailService->update($newMovie['thumbnail'], $movie->thumbnail);

        $movie->update($newMovie);
        $movie->genres()->sync($newMovie['genres']);

        return to_route('admin.movies.show', ['movie' => $movie->slug]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie): RedirectResponse
    {
        $this->thumbnailService->destroy($movie->thumbnail);

        $movie->delete();

        return to_route('admin.movies.index');
    }
}
