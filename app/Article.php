<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    
    public function getDurationAttribute()
    {
        $minutes = (int) round(str_word_count($this->content) / $this->wordsPerMinute());
        
        return "{$minutes} min";
    }

    protected function wordsPerMinute()
    {
        return 200;
    }

}
