<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Seats\StoreSeatsAction;
use App\Actions\Seats\UpdateSeatsAction;
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
        $templates = HallTemplate::query()->withCount('seats')->get();

        return Inertia::render('Admin/HallTemplates/Index', [
            'hall_templates' => HallTemplateListResource::collection($templates),
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
        /** @var HallTemplate $template */
        $template = HallTemplate::query()->create($request->validated());
        $storeSeats->handle($template, $request->validated()['seats']);

        session()->flash('message', [
            'type' => 'success',
            'text' => 'Зал успішно створено.',
        ]);

        return to_route('admin.hall_templates.show', $template);
    }

    /**
     * Display the specified resource.
     */
    public function show(HallTemplate $template): RedirectResponse
    {
        return to_route('admin.hall_templates.edit', $template);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HallTemplate $template): Response
    {
        return Inertia::render('Admin/HallTemplates/Edit', [
            'hall' => HallTemplateWithSeatsResource::make($template->load('seats')),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHallTemplateRequest $request, HallTemplate $template, UpdateSeatsAction $updateSeats): RedirectResponse
    {
        $updatedHall = $request->validated();

        $template->update($updatedHall);
        $updateSeats->handle($template, $updatedHall['updated_seats']);

        session()->flash('message', [
            'type' => 'success',
            'text' => 'Зал успішно оновлено.',
        ]);

        return to_route('admin.hall_templates.show', $template);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HallTemplate $template): RedirectResponse
    {
        $template->delete();

        session()->flash('message', [
            'type' => 'success',
            'text' => 'Зал успішно видалено.',
        ]);

        return to_route('admin.hall_templates.index');
    }
}
