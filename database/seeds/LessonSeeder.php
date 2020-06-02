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
                $document = YamlFrontMatter::parse(
                    File::get($file->getPathname())
                );

                if ($document->type === 'Article') {
                    $content = $this->createArticle($document);
                }

                if ($document->type === 'Quiz') {
                    $content = $this->createQuiz($document);
                }

                Lesson::create([
                    'title' => $document->title,
                    'slug' => $document->slug,
                    'description' => $document->description,
                    'content_type' => "App\\{$document->type}",
                    'content_id' => $content->id,
                    'series_id' => $series->id,
                ]);
            });
        });
    }

    public function createArticle($document)
    {
        return Article::create([
            'title' => $document->title,
            'content' => $document->body(),
        ]);
    }

    public function createQuiz($document)
    {
        $quiz = Quiz::create([
            'title' => $document->title,
        ]);

        collect($document->questions)->each(function ($options, $question) use ($quiz) {
            $question = Question::create([
                'title' => $question,
                'quiz_id' => $quiz->id,
            ]);
            
            collect($options)->each(function($correct, $option) use ($question) {
                Option::create([
                    'title' => $option,
                    'correct' => $correct,
                    'question_id' => $question->id,
                ]);
            });
        });

        return $quiz;
    }
}
