<?php

namespace App\Http\Controllers;

use App\Actions\Order\CreateNewOrderAction;
use App\Actions\Payment\ProcessPaymentAction;
use App\Actions\Seat\UpdateSeatsOrderIdAction;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Resources\Order\OrderPdfResource;
use App\Models\Order;
use App\Models\Seat;
use App\Services\FlashMessageService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
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
    public function show(Order $order): RedirectResponse|Response
    {
        if (Gate::denies('view', $order)) {
            return to_route('home');
        }

        return Inertia::render('Orders/Show', ['order' => $order]);
    }

    /**
     * Download order as PDF.
     */
    public function download(Order $order): RedirectResponse|Http\Response
    {
        if (Gate::denies('view', $order)) {
            return to_route('home');
        }

        $order->load('seats', 'screening.movie', 'screening.hall');
        $pdf = Pdf::loadView('pdf.order', [
            'order' => OrderPdfResource::make($order)->resolve(),
        ]);

        return $pdf->download($order['id'] . '-tickets.pdf');
    }

    /**
     * Preview order as PDF.
     */
    public function preview(Order $order): RedirectResponse|Http\Response
    {
        if (Gate::denies('view', $order)) {
            return to_route('home');
        }

        $order->load('seats', 'screening.movie', 'screening.hall');
        $pdf = Pdf::loadView('pdf.order', [
            'order' => OrderPdfResource::make($order)->resolve(),
        ]);

        return $pdf->stream($order['id'] . '-tickets.pdf');
    }

    /**
     * Verify if seat belongs to order.
     */
    public function verification(Order $order): JsonResponse
    {
        return response()->json([]);
    }
}
