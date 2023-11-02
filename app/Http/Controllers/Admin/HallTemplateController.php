<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Seat\StoreSeatsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HallTemplate\HallTemplateListRequest;
use App\Http\Requests\Admin\HallTemplate\StoreHallTemplateRequest;
use App\Http\Requests\Admin\HallTemplate\UpdateHallTemplateRequest;
use App\Http\Resources\Admin\HallTemplate\HallTemplateListResource;
use App\Http\Resources\Admin\HallTemplate\HallTemplateWithSeatsResource;
use App\Models\HallTemplate;
use App\Services\FlashMessageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class HallTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(HallTemplateListRequest $request): Response
    {
        $data = $request->validated();
        $searchQuery = $data['s'] ?? '';

        $hall_templates = HallTemplate::query()
            ->searched($searchQuery)
            ->select(['id', 'number', 'address', 'is_available'])
            ->withCount('seats')
            ->latest('updated_at')
            ->paginate(10)
            ->onEachSide(1);

        return Inertia::render('Admin/HallTemplates/Index', [
            'hallTemplates' => HallTemplateListResource::collection($hall_templates),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Admin/HallTemplates/Create');
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
        if ($message = session('message')) {
            session()->flash('message', $message);
        }

        return to_route('admin.hall_templates.edit', $hall_template);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HallTemplate $hall_template): Response
    {
        return Inertia::render('Admin/HallTemplates/Edit', [
            'hallTemplate' => HallTemplateWithSeatsResource::make($hall_template->load('seats'))->resolve(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateHallTemplateRequest $request,
        HallTemplate $hall_template,
        StoreSeatsAction $storeSeatsAction,
        FlashMessageService $flashMessageService
    ): RedirectResponse {
        $updatedHall = $request->validated();
        $seats = $updatedHall['seats'];
        unset($updatedHall['seats']);

        DB::beginTransaction();
        $hall_template->update($updatedHall);

        $hall_template->seats()->delete();
        $storeSeatsAction->handle($hall_template, $seats);
        DB::commit();

        $flashMessageService->success('Шаблон залу успішно оновлено.');

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
