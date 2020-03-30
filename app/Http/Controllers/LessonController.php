<?php

namespace App\Http\Controllers;

use App\Lesson;
use App\Series;
use Inertia\Inertia;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    
    public function show(Series $series, Lesson $lesson)
    {
        return Inertia::render('Lesson/Show');
    }

}
