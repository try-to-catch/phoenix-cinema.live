<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HallTemplateController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\Admin\MovieScreeningsController;
use App\Http\Controllers\Admin\ScreeningController;
use Illuminate\Support\Facades\Route;

Route::get('/', DashboardController::class)->name('dashboard');

Route::controller(MovieScreeningsController::class)->name('movie_screenings.')->group(function (){
    Route::get('/movies/screenings', 'index')->name('index');
    Route::get('/movies/{movie}/screenings', 'show')->name('show');
});

//Movie model use getRouteKeyName() method to get movie by slug
Route::resource('movies', MovieController::class);

Route::resource('hall-templates', HallTemplateController::class)
    ->names([
        'index' => 'hall_templates.index',
        'create' => 'hall_templates.create',
        'store' => 'hall_templates.store',
        'show' => 'hall_templates.show',
        'edit' => 'hall_templates.edit',
        'update' => 'hall_templates.update',
        'destroy' => 'hall_templates.destroy',
    ]);

Route::resource('screenings', ScreeningController::class)->except('index');
