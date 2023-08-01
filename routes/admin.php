<?php

use App\Http\Controllers\Admin\HallTemplateController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\Admin\ScreeningController;
use Illuminate\Support\Facades\Route;


//Movie model use getRouteKeyName() method to get movie by slug
Route::resource('movies', MovieController::class);

Route::prefix('hall-templates')->name('hall_templates.')->controller(HallTemplateController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::get('/{template}/edit', 'edit')->name('edit');
        Route::get('/{template}', 'show')->name('show');
        Route::post('/', 'store')->name('store');
        Route::match(['put', 'patch'], '/{template}', 'update')->name('update');
        Route::delete('/{template}', 'destroy')->name('destroy');
    });

Route::resource('screenings', ScreeningController::class);
