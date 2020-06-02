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
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Series::all()->each(function($series) {
            collect(File::files(database_path('seeds/data/' . $series->slug)))->each(function($file) use ($series) {
                $details = YamlFrontMatter::parse(
                    File::get($file->getPathname())
                );
                $article = Article::create([
                    'title' => $details->title,
                    'content' => $details->body(),
                ]);
                Lesson::create([
                    'title' => $details->title,
                    'slug' => $details->slug,
                    'description' => $details->description,
                    'content_type' => Article::class,
                    'content_id' => $article->id,
                    'series_id' => $series->id,
                ]);
            });
        });
    }
}
