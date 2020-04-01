<?php

use App\Lesson;
use App\Series;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Series::all()->each(function ($series) {
            factory(Lesson::class, 3)->create([
                'series_id' => $series->id,
            ]);
        });
    }
}
