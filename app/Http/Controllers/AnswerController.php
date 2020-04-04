<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Lesson;
use App\Series;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AnswerController extends Controller
{
    
    public function store(Request $request, Series $series, Lesson $lesson)
    {
        $data = $request->validate([
            'option_id' => 'required|numeric|exists:options,id'
        ]);

        Answer::create([
            'user_id' => Auth::user()->id,
            'option_id' => $data['option_id']
        ]);

        return Redirect::route('lesson.show', [$series->slug, $lesson->slug]);
    }

}
