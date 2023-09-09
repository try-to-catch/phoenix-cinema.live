<?php

namespace App\Http\Controllers;

use App\Actions\Payment\ProcessPaymentAction;
use App\Http\Requests\Order\StoreOrderRequest;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request, ProcessPaymentAction $paymentAction): Response
    {
//        $paymentAction->handle([]);
        dd($request->all());
        return Inertia::render('Screenings/Show');
    }
}
