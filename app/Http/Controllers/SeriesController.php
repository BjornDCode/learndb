<?php

namespace App\Http\Controllers;

use App\Series;
use Inertia\Inertia;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    
    public function index()
    {
        return Inertia::render('Series/Index', [
            'series' => Series::all(),
        ]);
    }

}
