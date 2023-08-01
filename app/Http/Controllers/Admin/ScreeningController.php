<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Hall\CreateHallAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Screening\StoreScreeningRequest;
use App\Http\Resources\Admin\HallTemplate\HallTemplateMinResource;
use App\Http\Resources\Admin\Movie\MovieMinResource;
use App\Http\Resources\Admin\Screening\ScreeningItemResource;
use App\Http\Resources\Admin\Screening\ScreeningListResource;
use App\Models\HallTemplate;
use App\Models\Movie;
use App\Models\Screening;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ScreeningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $screenings = Screening::query()
            ->select('id', 'movie_id', 'hall_id', 'start_time', 'end_time')
            ->with('movie:id,slug,title,thumbnail,duration_in_minutes', 'hall:id,title')
            ->latest('start_time')
            ->paginate(10);

        return Inertia::render('Admin/Screenings/Index', [
            'screenings' => ScreeningListResource::collection($screenings),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Admin/Screenings/Create', [
            'movies' => MovieMinResource::collection(Movie::withoutCompleted()->get(['id', 'title'])),
            'hall_templates' => HallTemplateMinResource::collection(HallTemplate::available()->get(['id', 'title'])),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreScreeningRequest $request, CreateHallAction $createHall): RedirectResponse
    {
        $newScreening = $request->validated();

        $hall = $createHall->handle(HallTemplate::findOrFail($newScreening['hall_template_id']));

        $screening = $hall->screenings()->create([
            'movie_id' => $newScreening['movie_id'],
            'start_time' => $newScreening['start_time'],
            'end_time' => $newScreening['end_time'],
            'standard_seat_price_in_cents' => $newScreening['standard_seat_price'],
            'premium_seat_price_in_cents' => $newScreening['premium_seat_price'],
        ]);

        return redirect()->route('admin.screenings.show', $screening);


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
        return Inertia::render('Admin/Screenings/Edit', [
            'screening' => ScreeningItemResource::make($screening),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Screening $screening)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Screening $screening)
    {
        //
    }
}
