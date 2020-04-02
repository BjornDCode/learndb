<?php

use App\Quiz;
use App\Video;
use App\Lesson;
use App\Option;
use App\Series;
use App\Article;
use App\Question;
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
            factory(Lesson::class)->create([
                'series_id' => $series->id,
                'content_type' => Article::class,
                'content_id' => factory(Article::class)->create()->id, 
            ]);

            factory(Lesson::class)->create([
                'series_id' => $series->id,
                'content_type' => Video::class,
                'content_id' => factory(Video::class)->create()->id, 
            ]);

            factory(Lesson::class)->create([
                'series_id' => $series->id,
                'content_type' => Quiz::class,
                'content_id' => factory(Quiz::class)->create()->id, 
            ]);
        });

        Quiz::all()->each(function ($quiz) {
            factory(Question::class, 2)->create([
                'quiz_id' => $quiz->id,
            ]);
        });

        Question::all()->each(function ($question) {
            factory(Option::class, 4)->create([
                'question_id' => $question->id,
            ]);
        });
    }
}
