<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Order\ProfileOrderListResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $orders = Order::query()
            ->select('id', 'screening_id', 'completed_at', 'created_at')
            ->with([
                'screening' => function ($query) {
                    $query
                        ->with(['movie' => fn ($query) => $query->select('id', 'title', 'slug')])
                        ->select('id', 'movie_id', 'start_time');
                },
            ])
            ->withCount('seats')
            ->latest('created_at')
            ->paginate();

        return Inertia::render('Profile/Orders/Index', [
            'orders' => ProfileOrderListResource::collection($orders),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
