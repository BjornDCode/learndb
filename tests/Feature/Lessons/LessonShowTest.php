<?php

namespace Tests\Feature\Lessons;

use App\Lesson;
use App\Series;
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

        $response = $this->get(
            route('lesson.show', [
                'series' => $lesson->series->slug,
                'lesson' => $lesson->slug,
            ])
        );

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function authenticated_users_can_see_the_lesson_page()
    {
        $this->login();

        $lesson = factory(Lesson::class)->create();

        $response = $this->get(
            route('lesson.show', [
                'series' => $lesson->series->slug,
                'lesson' => $lesson->slug,
            ])
        );

        $response->assertStatus(200);
        $response->assertInertiaViewIs('Lesson/Show');
    }

    /** @test */
    public function the_lesson_must_belong_to_the_series()
    {
        $this->withExceptionHandling();
        $this->login();

        $lesson = factory(Lesson::class)->create();
        $series = factory(Series::class)->create();

        $response = $this->get(
            route('lesson.show', [
                'series' => $series->slug,
                'lesson' => $lesson->slug,
            ])
        );

        $response->assertStatus(404);
    }

}
