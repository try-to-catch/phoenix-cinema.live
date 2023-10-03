<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ScreeningController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', HomeController::class)->name('home');

Route::resource('movies', MovieController::class)->only(['index', 'show']);

Route::get('screenings/{screening}', [ScreeningController::class, 'show'])->name('screenings.show');

Route::prefix('orders')->group(function () {
    Route::post('/', [OrderController::class, 'store'])->name('orders.store');

    Route::get('/{order}/thank-you', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/{order}/download', [OrderController::class, 'download'])->name('orders.download');
    Route::get('/{order}/preview', [OrderController::class, 'preview'])->name('orders.preview');

    Route::get('/{order}/check', [OrderController::class, 'verification'])->middleware('role:admin,cashier')->name('orders.check');
});

require __DIR__.'/auth.php';

Route::fallback(function () {
    return redirect()->route('home');
});
