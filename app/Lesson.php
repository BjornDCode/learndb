<?php

namespace App;

use App\Series;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    
    public function series()
    {
        return $this->belongsTo(Series::class);
    }

}
