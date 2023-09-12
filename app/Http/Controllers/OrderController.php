<?php

namespace App\Http\Controllers;

use App\Actions\Order\CreateNewOrderAction;
use App\Actions\Payment\ProcessPaymentAction;
use App\Actions\Seat\UpdateSeatsOrderIdAction;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Models\Order;
use App\Models\Seat;
use App\Services\FlashMessageService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(
        StoreOrderRequest        $request,
        ProcessPaymentAction     $paymentAction,
        FlashMessageService      $flashMessageService,
        UpdateSeatsOrderIdAction $updateSeatsOrderIdAction,
        CreateNewOrderAction     $createNewOrderAction
    ): RedirectResponse
    {
        $data = $request->validated();

        if (!$paymentAction->handle($data['card_data'])) {
            $flashMessageService->failure('Оплата не пройшла! Щось пішло не так');
            return redirect()->back()->with('errors', ['card_data' => 'Реквізити картки невірні']);
        }

        $order = $createNewOrderAction->handle($request, Seat::find($data['seat_ids'][0])->hall->screening_id);
        $updateSeatsOrderIdAction->handle($data['seat_ids'], $order->id);

        return to_route('orders.show', $order);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order): Response
    {
        return Inertia::render('Orders/Show');
    }
}
