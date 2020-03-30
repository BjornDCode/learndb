<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    
    public function show()
    {
        return Inertia::render('Lesson/Show');
    }

}
