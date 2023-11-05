<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Hall\CreateHallAction;
use App\Actions\Movies\GetMoviesAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Screening\StoreScreeningRequest;
use App\Http\Requests\Admin\Screening\UpdateScreeningRequest;
use App\Http\Resources\Admin\HallTemplate\HallTemplateMinResource;
use App\Http\Resources\Admin\Movie\MovieMinResource;
use App\Http\Resources\Admin\Screening\ScreeningItemResource;
use App\Models\HallTemplate;
use App\Models\Screening;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ScreeningController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(GetMoviesAction $getMoviesAction): Response
    {
        $movies = $getMoviesAction->handle(['id','title']);
        return Inertia::render('Admin/Screenings/Create', [
            'movies' => MovieMinResource::collection($movies)->resolve(),
            'hallTemplates' => HallTemplateMinResource::collection(
                HallTemplate::available()->get(['id', 'address', 'number'])
            )->resolve(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreScreeningRequest $request, CreateHallAction $createHall): RedirectResponse
    {
        $newScreening = $request->validated();
        $hallTemplateId = $newScreening['hall_template_id'];
        unset($newScreening['hall_template_id']);

        $screening = Screening::create($newScreening);

        $createHall->handle($screening, HallTemplate::find($hallTemplateId));

        return to_route('admin.screenings.show', $screening);

    }

    /**
     * Display the specified resource.
     */
    public function show(Screening $screening): RedirectResponse
    {
        return to_route('admin.screenings.edit', ['screening' => $screening->id]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Screening $screening): Response
    {
        $screening->load('movie:id,slug,title,thumbnail,duration_in_minutes', 'hall:id,address,number,screening_id');

        return Inertia::render('Admin/Screenings/Edit', [
            'screening' => ScreeningItemResource::make($screening)->resolve(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateScreeningRequest $request, Screening $screening): RedirectResponse
    {
        $screening->update($request->validated());

        return to_route('admin.screenings.show', $screening);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Screening $screening): RedirectResponse
    {
        $screening->delete();

        return to_route('admin.movie_screenings.index');

    }
}
