<?php

use Illuminate\Support\Facades\Route;


Route::resource('movies', \App\Http\Controllers\Admin\MovieController::class)
    ->only(['index', 'create', 'store', 'show'])
    ->names('movies');
