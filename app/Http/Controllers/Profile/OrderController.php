<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Order\ProfileOrderListResource;
use App\Models\Order;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $orders = auth()->user()->orders()
            ->select('id', 'screening_id', 'created_at')
            ->with([
                'screening' => function ($query) {
                    $query
                        ->with(['movie' => fn ($query) => $query->select('id', 'title', 'slug')])
                        ->select('id', 'movie_id', 'start_time', 'end_time');
                },
            ])
            ->withCount('seats')
            ->latest('created_at')
            ->paginate(8);

        return Inertia::render('Profile/Orders/Index', [
            'orders' => ProfileOrderListResource::collection($orders),
        ]);
    }
}
