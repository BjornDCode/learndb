<?php

namespace Tests\Feature\Lessons;

use App\Lesson;
use App\Series;
use App\Article;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LessonShowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function unauthenticated_users_cannot_see_the_lesson_page()
    {
        $this->withExceptionHandling();

        $lesson = factory(Lesson::class)->create();

        $this->get(
            route('lesson.show', [
                'series' => $lesson->series->slug,
                'lesson' => $lesson->slug,
            ])
        )
        ->assertRedirect(route('login'));
    }

    /** @test */
    public function authenticated_users_can_see_the_lesson_page()
    {
        $this->login();

        $lesson = factory(Lesson::class)->create();

        $this->get(
            route('lesson.show', [
                'series' => $lesson->series->slug,
                'lesson' => $lesson->slug,
            ])
        )
        ->assertStatus(200)
        ->assertInertiaViewIs('Lesson/Show');
    }

    /** @test */
    public function the_lesson_must_belong_to_the_series()
    {
        $this->withExceptionHandling();
        $this->login();

        $lesson = factory(Lesson::class)->create();
        $series = factory(Series::class)->create();

        $this->get(
            route('lesson.show', [
                'series' => $series->slug,
                'lesson' => $lesson->slug,
            ])
        )->assertStatus(404);
    }

    /** @test */
    public function it_returns_the_lesson_details()
    {
        $this->login();

        $lesson = factory(Lesson::class)->create();

        $this->get(
            route('lesson.show', [
                'series' => $lesson->series->slug,
                'lesson' => $lesson->slug,
            ])
        )
        ->assertJsonFragmentInProp('lesson', [
            'id' => $lesson->id,
            'title' => $lesson->title,
            'description' => $lesson->description,
        ]);
    }    

    /** @test */
    public function it_returns_the_lesson_article()
    {
        $this->login();

        $article = factory(Article::class)->create();
        $lesson = factory(Lesson::class)->create([
            'content_type' => Article::class,
            'content_id' => $article->id,
        ]);

        $this->get(
            route('lesson.show', [
                'series' => $lesson->series->slug,
                'lesson' => $lesson->slug,
            ])
        )
        ->assertJsonFragmentInProp('lesson', [
            'content' => [
                'id' => $article->id,
                'title' => $article->title,
                'content' => $article->content,
                'duration' => $article->duration,
            ]
        ]);
    }

    /** @test */
    public function it_returns_all_lessons_for_the_series()
    {
        $this->login();

        $lesson = factory(Lesson::class)->create();

        $lessons = factory(Lesson::class, 5)->create([
            'series_id' => $lesson->series->id,
        ]);

        $this->get(
            route('lesson.show', [
                'series' => $lesson->series->slug,
                'lesson' => $lesson->slug,
            ])
        )
        ->assertPropCount('lessons', 6)
        ->assertJsonFragmentInProp('lessons', [
            'id' => $lessons->first()->id,
            'title' => $lessons->first()->title,
            'description' => $lessons->first()->description,
        ]);
    }

}
