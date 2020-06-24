<?php

namespace App\Http\Controllers;

use App\Lesson;
use App\Series;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\LessonResource;
use App\Http\Resources\SeriesResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\ResourceResource;

class LessonController extends Controller
{
    
    public function show(Series $series, $slug)
    {
        $lesson = null;
        DB::transaction(function () use ($slug, &$lesson) {
            $lesson = DB::table('lessons')->where('slug', $slug)->first();


            DB::statement(
                DB::raw("
                    INSERT INTO activities (user_id, item_id, item_type, type, created_at, updated_at)
                    VALUES (:user_id, :item_id, :item_type, :type, NOW(), NOW())
                "), 
                [
                    'user_id' => Auth::user()->id,
                    'item_id' => $lesson->id,
                    'item_type' => Lesson::class,
                    'type' => 'started',
                ]
            );
        });

        // Auth::user()->activities()->firstOrCreate([
        //     'item_id' => $lesson->id,
        //     'item_type' => Lesson::class,
        //     'type' => 'started',
        // ]);

        $lesson = Lesson::find($lesson->id);
        return Inertia::render('Lesson/Show', [
            'series' => SeriesResource::make($lesson->series),
            'lesson' => LessonResource::make($lesson),
            'lessons' => LessonResource::collection($lesson->series->lessons),
            'resources' => ResourceResource::collection($lesson->resources),
            'comments' => CommentResource::collection($lesson->comments),
        ]);
    }

}
