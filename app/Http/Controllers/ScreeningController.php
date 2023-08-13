<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ScreeningController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Request $request): Response
    {
        return Inertia::render('Screenings/Show');
    }
}
