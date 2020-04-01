<?php

namespace App\Http\Controllers;

use App\Lesson;
use App\Series;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Resources\LessonResource;

class LessonController extends Controller
{
    
    public function show(Series $series, Lesson $lesson)
    {
        return Inertia::render('Lesson/Show', [
            'lesson' => LessonResource::make($lesson),
            'lessons' => LessonResource::collection($lesson->series->lessons),
        ]);
    }

}
