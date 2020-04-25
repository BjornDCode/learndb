<?php

namespace App;

use App\Lesson;
use App\Activity;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Series extends Model implements Searchable
{

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this,
            $this->title,
            route('series.show', [ $this->slug ]),
        );
    }

    public function getStartedLessonsCount()
    {
        return Activity::where('user_id', Auth::user()->id)
            ->where('item_type', Lesson::class)
            ->whereIn('item_id', $this->lessons->pluck('id'))
            ->get()
            ->unique('item_id')
            ->count();
    }

    public function getStartedAttribute()
    {
        return $this->getStartedLessonsCount() > 0;
    }


    public function getProgressAttribute()
    {
        return $this->started ? $this->getStartedLessonsCount() . "/" . $this->lessons->count() . " lessons" : $this->lessons->count() . " lessons";
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

}
