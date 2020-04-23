<?php

namespace App\Http\Controllers;

use App\Lesson;
use App\Series;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Resources\LessonResource;
use App\Http\Resources\SeriesResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\ResourceResource;

class LessonController extends Controller
{
    
    public function show(Series $series, Lesson $lesson)
    {
        return Inertia::render('Lesson/Show', [
            'series' => SeriesResource::make($lesson->series),
            'lesson' => LessonResource::make($lesson),
            'lessons' => LessonResource::collection($lesson->series->lessons),
            'resources' => ResourceResource::collection($lesson->resources),
            'comments' => CommentResource::collection($lesson->comments),
        ]);
    }

}
