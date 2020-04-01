<?php

namespace App;

use App\Question;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{

    public function getTypeAttribute()
    {
        return 'Quiz';
    }
    
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function getDurationAttribute()
    {
        return "{$this->questionsAnsweredByUser()->count()}/{$this->questions->count()} questions";
    }

    protected function questionsAnsweredByUser()
    {
        return Auth::user()->answers->whereIn('question_id', $this->questions->pluck('id'));
    }

}
