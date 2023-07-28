<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Seats\StoreSeatsAction;
use App\Actions\Seats\UpdateSeatsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Hall\StoreHallRequest;
use App\Http\Requests\Admin\Hall\UpdateHallRequest;
use App\Http\Resources\Admin\Hall\HallListResource;
use App\Http\Resources\Admin\Hall\HallWithSeatsResource;
use App\Models\Hall;
use App\Models\Seat;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class HallController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Hall::class, 'hall');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Admin/Halls/Index', [
            'halls' => HallListResource::collection(Hall::wherePreset()->withCount('seats')->get()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Admin/Halls/Create',
            [
                'seat_types' => Seat::SEAT_TYPES,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHallRequest $request, StoreSeatsAction $storeSeats): RedirectResponse
    {
        $hall = Hall::create($request->validated());
        $storeSeats->handle($hall, $request->validated()['seats']);

        session()->flash('message', [
            'type' => 'success',
            'text' => 'Зал успішно створено.',
        ]);

        return to_route('admin.halls.show', $hall);
    }

    /**
     * Display the specified resource.
     */
    public function show(Hall $hall): RedirectResponse
    {
        return to_route('admin.halls.edit', $hall);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hall $hall): Response
    {
        return Inertia::render('Admin/Halls/Edit', [
            'hall' => HallWithSeatsResource::make($hall->load('seats')),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHallRequest $request, Hall $hall, UpdateSeatsAction $updateSeats): RedirectResponse
    {
        $updatedHall = $request->validated();

        $hall->update($updatedHall);
        $updateSeats->handle($hall, $updatedHall['updated_seats']);

        session()->flash('message', [
            'type' => 'success',
            'text' => 'Зал успішно оновлено.',
        ]);

        return to_route('admin.halls.show', $hall);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hall $hall): RedirectResponse
    {
        $hall->delete();

        session()->flash('message', [
            'type' => 'success',
            'text' => 'Зал успішно видалено.',
        ]);

        return to_route('admin.halls.index');
    }
}
