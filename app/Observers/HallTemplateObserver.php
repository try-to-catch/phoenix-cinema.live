<?php

namespace App\Observers;

use App\Models\HallTemplate;
use App\Services\FlashMessageService;

class HallTemplateObserver
{
    public function __construct(public FlashMessageService $flashMessageService)
    {
    }

    /**
     * Handle events after all transactions are committed.
     */
    public bool $afterCommit = true;

    /**
     * Handle the HallTemplate "created" event.
     */
    public function created(HallTemplate $hallTemplate): void
    {
        $this->flashMessageService->success('Шаблон залу успішно створено.');
    }

    /**
     * Handle the HallTemplate "updated" event.
     */
    public function updated(HallTemplate $hallTemplate): void
    {
        $this->flashMessageService->success('Шаблон залу успішно оновлено.');
    }

    /**
     * Handle the HallTemplate "deleted" event.
     */
    public function deleted(HallTemplate $hallTemplate): void
    {
        $this->flashMessageService->success('Шаблон залу успішно видалено.');
    }
}
