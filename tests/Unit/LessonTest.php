<?php

namespace Tests\Unit;

use App\Quiz;
use App\Video;
use App\Lesson;
use App\Series;
use App\Article;
use App\Comment;
use App\Resource;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LessonTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_series()
    {
        $lesson = factory(Lesson::class)->create();

        $this->assertInstanceOf(Series::class, $lesson->series);
    }

    /** @test */
    public function it_can_have_an_article_as_content()
    {
        $article = factory(Article::class)->create();
        $lesson = factory(Lesson::class)->create([
            'content_id' => $article->id,
            'content_type' => Article::class,
        ]);

        $this->assertInstanceOf(Article::class, $lesson->content);
    }

    /** @test */
    public function it_can_have_a_video_as_content()
    {
        $video = factory(Video::class)->create();
        $lesson = factory(Lesson::class)->create([
            'content_id' => $video->id,
            'content_type' => Video::class,
        ]);

        $this->assertInstanceOf(Video::class, $lesson->content);
    }
    
    /** @test */
    public function it_can_have_a_quiz_as_content()
    {
        $quiz = factory(Quiz::class)->create();
        $lesson = factory(Lesson::class)->create([
            'content_id' => $quiz->id,
            'content_type' => Quiz::class,
        ]);

        $this->assertInstanceOf(Quiz::class, $lesson->content);
    }

    /** @test */
    public function it_has_resources()
    {
        $lesson = factory(Lesson::class)->create();
        factory(Resource::class, 2)->create([
            'lesson_id' => $lesson->id,
        ]);

        $this->assertInstanceOf(Collection::class, $lesson->resources);
        $this->assertInstanceOf(Resource::class, $lesson->resources()->first());
    }

    /** @test */
    public function it_has_comments()
    {
        $lesson = factory(Lesson::class)->create();
        factory(Comment::class, 2)->create([
            'lesson_id' => $lesson->id,
        ]);

        $this->assertInstanceOf(Collection::class, $lesson->comments);
        $this->assertInstanceOf(Comment::class, $lesson->comments()->first());
    }

}
