<?php

use App\Quiz;
use App\Video;
use App\Lesson;
use App\Option;
use App\Series;
use App\Article;
use App\Comment;
use App\Question;
use App\Resource;
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
        tap($this->getSeries('database-normalisation'), function ($series) {
            $article1 = Article::create([
                'title' => 'What is database normalisation?',
                'content' => file_get_contents(database_path('seeds/data/database-normalisation/What is database normalisation?.md'))
            ]);
        });
        // $databaseNormalisationSeries = Series::where('slug', 'database-normalisation')->get();
        // $erDiagramsSeries = Series::where('slug', 'er-diagrams')->get();
        // $postgresSeries = Series::where('slug', 'postgresql')->get();
        // $phpAndDatabasesSeries = Series::where('slug', 'php-and-databases')->get();
        // $relationalDatabasesSeries = Series::where('slug', 'relational-databases')->get();
        // $sqlSeries = Series::where('slug', 'sql')->get();
        // Series::all()->each(function ($series) {
        //     factory(Lesson::class, 3)->create([
        //         'series_id' => $series->id,
        //     ]);
        // });

    }

    private function getSeries($slug)
    {
        return Series::where('slug', $slug)->get();
    }
}
