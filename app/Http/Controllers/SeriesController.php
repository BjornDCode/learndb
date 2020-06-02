<?php

namespace App\Http\Controllers;

use App\Series;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Resources\SeriesResource;
use Illuminate\Support\Facades\Redirect;

class SeriesController extends Controller
{
    
    public function index()
    {
        return Inertia::render('Series/Index', [
            'series' => SeriesResource::collection(Series::all()),
            'current_series' => SeriesResource::collection(Series::all()->filter(function ($series) {
                return $series->started && !$series->finished;
            })),
        ]);
    }

    public function show(Series $series)
    {
        return Redirect::to(
            route('lesson.show', [
                'series' => $series->slug,
                'lesson' => $series->nextUnfinishedLesson()->slug,
            ])
        );
    }

}
