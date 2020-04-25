<?php

namespace App;

use App\Series;
use App\Comment;
use App\Resource;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    
    public function series()
    {
        return $this->belongsTo(Series::class);
    }

    public function content()
    {
        return $this->morphTo();
    }

    public function resources()
    {
        return $this->hasMany(Resource::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getActivityStatus()
    {
        return $this->activity ? $this->activity->type : null;
    }

}
