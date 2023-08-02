<?php

namespace App\Services;

class FlashMessageService
{
    /**
     * Set the flash success message in session.
     */
    public function success(string $message): void
    {
        session()->flash('message', ['type' => 'success', 'text' => $message]);
    }

    public function failure(string $message): void
    {
        session()->flash('message', ['type' => 'failure', 'text' => $message]);
    }
}
