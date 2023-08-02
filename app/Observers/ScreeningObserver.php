<?php

namespace App\Observers;

use App\Models\Screening;
use App\Services\FlashMessageService;

class ScreeningObserver
{
    public function __construct(public FlashMessageService $flashMessageService)
    {
    }

    public bool $afterCommit = true;

    /**
     * Handle the Screening "created" event.
     */
    public function created(Screening $screening): void
    {
        $this->flashMessageService->success('Сеанс успішно створено.');
    }

    /**
     * Handle the Screening "updated" event.
     */
    public function updated(Screening $screening): void
    {
        $this->flashMessageService->success('Сеанс успішно оновлено.');
    }

    /**
     * Handle the Screening "deleted" event.
     */
    public function deleted(Screening $screening): void
    {
        $this->flashMessageService->success('Сеанс успішно видалено.');
    }
}
