<?php

use App\Http\Controllers\Admin\MovieController;
use Illuminate\Support\Facades\Route;


Route::resource('movies', MovieController::class);
