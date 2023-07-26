<?php

use App\Http\Controllers\Admin\HallController;
use App\Http\Controllers\Admin\MovieController;
use Illuminate\Support\Facades\Route;


Route::resource('movies', MovieController::class);
Route::resource('halls', HallController::class);
