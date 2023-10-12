<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Seat\StoreSeatsAction;
use App\Actions\Seat\UpdateSeatsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HallTemplate\StoreHallTemplateRequest;
use App\Http\Requests\Admin\HallTemplate\UpdateHallTemplateRequest;
use App\Http\Resources\Admin\HallTemplate\HallTemplateListResource;
use App\Http\Resources\Admin\HallTemplate\HallTemplateWithSeatsResource;
use App\Models\HallTemplate;
use App\Models\Seat;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class HallTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $hall_templates = HallTemplate::query()->withCount('seats')->get();

        return Inertia::render('Admin/HallTemplates/Index', [
            'hall_templates' => HallTemplateListResource::collection($hall_templates),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Admin/HallTemplates/Create',
            [
                'seat_types' => Seat::SEAT_TYPES,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHallTemplateRequest $request, StoreSeatsAction $storeSeats): RedirectResponse
    {
        $newTemplate = $request->validated();
        $seats = $newTemplate['seats'];
        unset($newTemplate['seats']);

        $hall_template = HallTemplate::create($newTemplate);
        $storeSeats->handle($hall_template, $seats);

        return to_route('admin.hall_templates.show', $hall_template);
    }

    /**
     * Display the specified resource.
     */
    public function show(HallTemplate $hall_template): RedirectResponse
    {
        return to_route('admin.hall_templates.edit', $hall_template);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HallTemplate $hall_template): Response
    {
        return Inertia::render('Admin/HallTemplates/Edit', [
            'hall_template' => HallTemplateWithSeatsResource::make($hall_template->load('seats'))->resolve(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHallTemplateRequest $request, HallTemplate $hall_template, UpdateSeatsAction $updateSeats): RedirectResponse
    {
        $updatedHall = $request->validated();
        $seats = $updatedHall['updated_seats'];
        unset($updatedHall['updated_seats']);

        $hall_template->update($updatedHall);
        $updateSeats->handle($hall_template, $seats);

        return to_route('admin.hall_templates.show', $hall_template);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HallTemplate $hall_template): RedirectResponse
    {
        $hall_template->delete();

        return to_route('admin.hall_templates.index');
    }
}
