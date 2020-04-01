<?php

namespace App;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    
    public function users()
    {
        return $this->belongsToMany(User::class, 'answers');
    }

    public function hasBeenAnsweredByUser()
    {
        return $this->users->where('id', Auth::user()->id)->count() > 0;
    }

}
