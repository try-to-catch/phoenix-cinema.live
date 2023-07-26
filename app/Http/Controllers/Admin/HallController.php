<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Seat\StoreSeatsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Hall\StoreHallRequest;
use App\Http\Resources\Admin\Hall\HallListResource;
use App\Http\Resources\Admin\Hall\HallWithSeatsResource;
use App\Models\Hall;
use App\Models\Seat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HallController extends Controller
{
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

        return redirect()->route('admin.halls.show', $hall);
    }

    /**
     * Display the specified resource.
     */
    public function show(Hall $hall): RedirectResponse
    {
        return redirect()->route('admin.halls.edit', $hall);
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
    public function update(Request $request, Hall $hall)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hall $hall)
    {
        //
    }
}
