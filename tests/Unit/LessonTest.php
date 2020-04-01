<?php

namespace Tests\Unit;

use App\Lesson;
use App\Series;
use App\Article;
use Tests\TestCase;
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

}
