<?php

namespace App\Actions\Payment;

class ProcessPaymentAction
{
    /**
     * Emit payment processing.
     */
    public function handle(array $cardData): bool
    {
        return true;
    }
}
