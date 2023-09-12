<?php

namespace App\Actions\Order;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CreateNewOrderAction
{
    /**
     * Create new order.
     */
    public function handle(Request $request, $screeningId): Builder|Model
    {
        $newOrder = ['screening_id' => $screeningId];

        if ($request->user()) {
            $newOrder['user_id'] = $request->user()->id;
        } else {
            $newOrder['session_id'] = $request->session()->getId();
        }

        return Order::query()->create($newOrder);
    }
}
