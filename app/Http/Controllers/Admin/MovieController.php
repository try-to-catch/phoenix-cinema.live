<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Genres\getAllGenresAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Movie\MovieListRequest;
use App\Http\Requests\Admin\Movie\StoreMovieRequest;
use App\Http\Requests\Admin\Movie\UpdateMovieRequest;
use App\Http\Resources\Admin\Genre\GenreResource;
use App\Http\Resources\Admin\Movie\MovieListResource;
use App\Http\Resources\Admin\Movie\MovieResource;
use App\Models\Movie;
use App\Services\ImageService;
use App\Services\MovieBannerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class MovieController extends Controller
{
    public function __construct(protected ImageService $imageService, protected MovieBannerService $bannerService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(MovieListRequest $request): Response
    {
        $data = $request->validated();
        $searchQuery = $data['s'] ?? '';

        $movies = Movie::with('genres')
            ->searched($searchQuery)
            ->select(['id', 'title', 'slug', 'thumbnail', 'age_restriction', 'director', 'start_showing', 'end_showing'])
            ->latest('updated_at')
            ->paginate(10)
            ->onEachSide(1);

        return Inertia::render('Admin/Movies/Index', [
            'movies' => MovieListResource::collection($movies),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(getAllGenresAction $getAllGenresAction): Response
    {
        $genres = $getAllGenresAction->handle();

        return Inertia::render('Admin/Movies/Create', [
            'genres' => GenreResource::collection($genres)->resolve(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMovieRequest $request): RedirectResponse
    {
        $newMovie = $request->validated();
        $newMovie['thumbnail'] = $this->imageService->store($newMovie['thumbnail'], 'images/movies');
        $genres = $newMovie['genres'];
        $banner = $newMovie['banner'] ?? null;

        unset($newMovie['genres'], $newMovie['banner']);

        DB::beginTransaction();
        /** @var Movie $movie */
        $movie = Movie::query()->create($newMovie);
        $movie->genres()->attach($genres);
        if (isset($banner['fact'])) {
            $this->bannerService->create($movie, $banner);
        }
        DB::commit();

        return to_route('admin.movies.show', $movie);
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie): RedirectResponse
    {
        if ($message = session('message')) {
            session()->flash('message', $message);
        }

        return to_route('admin.movies.edit', $movie);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $movie, getAllGenresAction $getAllGenresAction): Response
    {
        $movie->load(['genres', 'banner']);

        return Inertia::render('Admin/Movies/Edit', [
            'movie' => MovieResource::make($movie)->resolve(),
            'genres' => GenreResource::collection($getAllGenresAction->handle())->resolve(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMovieRequest $request, Movie $movie): RedirectResponse
    {
        $movie->load('banner');
        $dataForUpdate = $request->validated();

        if (! is_null($dataForUpdate['thumbnail'])) {
            $dataForUpdate['thumbnail'] = $this->imageService->update($dataForUpdate['thumbnail'], $movie->thumbnail);
        } else {
            $dataForUpdate['thumbnail'] = $movie->thumbnail;
        }

        $genres = $dataForUpdate['genres'];
        $banner = $dataForUpdate['banner'] ?? null;
        unset($dataForUpdate['genres'], $dataForUpdate['banner']);

        DB::transaction(function () use ($movie, $dataForUpdate, $genres, $banner) {
            $movie->update($dataForUpdate);
            $movie->genres()->sync($genres);

            if (! is_null($banner)) {
                $this->bannerService->update($movie, $banner);
            }
        });

        return to_route('admin.movies.show', $movie);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie): RedirectResponse
    {
        $this->imageService->destroy($movie->thumbnail);

        DB::transaction(function () use ($movie) {
            if ($movie->banner) {
                $this->bannerService->destroy($movie);
            }

            $movie->delete();
        });

        return to_route('admin.movies.index');
    }
}
