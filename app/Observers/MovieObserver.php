<?php

namespace App\Observers;

use App\Models\Movie;
use App\Services\FlashMessageService;

class MovieObserver
{
    public function __construct(public FlashMessageService $flashMessageService)
    {
    }

    /**
     * Handle events after all transactions are committed.
     */
    public bool $afterCommit = true;

    /**
     * Handle the Movie "created" event.
     */
    public function created(Movie $movie): void
    {
        $this->flashMessageService->success('Фільм успішно створено.');
    }

    /**
     * Handle the Movie "updated" event.
     */
    public function updated(Movie $movie): void
    {
        $this->flashMessageService->success('Фільм успішно оновлено.');
    }

    /**
     * Handle the Movie "deleted" event.
     */
    public function deleted(Movie $movie): void
    {
        $this->flashMessageService->success('Фільм успішно видалено.');
    }
}
