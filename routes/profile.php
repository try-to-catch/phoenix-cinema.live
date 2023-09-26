<?php

use App\Http\Controllers\Profile\OrderController;
use App\Http\Controllers\Profile\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/security', [ProfileController::class, 'edit'])->name('security');
Route::patch('/', [ProfileController::class, 'update'])->name('update');
Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');

Route::prefix('orders')->name('orders.')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::get('/{order}', [OrderController::class, 'show'])->name('show');
});

Route::fallback(function () {
    return redirect()->route('orders.index');
});
