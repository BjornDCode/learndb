<?php

namespace App;

use App\Lesson;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
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

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

}
