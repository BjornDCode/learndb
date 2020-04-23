<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CommentController extends Controller
{
    
    public function store(Request $request)
    {
        $data = $request->validate([
            'content' => 'required',
            'lesson_id' => 'required_without:parent_id|numeric|exists:lessons,id',
            'parent_id' => 'required_without:lesson_id|numeric|exists:comments,id',
        ]);

        Comment::create(
            array_merge($data, [
                'author_id' => Auth::user()->id,
            ])
        );

        return Redirect::back();
    }

}
