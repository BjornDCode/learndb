<?php

namespace Tests\Feature\Series;

use App\Lesson;
use App\Series;
use App\Activity;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SeriesShowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function unauthenticated_users_cannot_hit_the_series_url()
    {
        $this->withExceptionHandling();

        $series = factory(Series::class)->create();

        $this->get(
            route('series.show', [
                'series' => $series->slug,
            ])
        )
        ->assertRedirect(route('login'));
    }

    /** @test */
    public function it_redirects_to_the_first_lesson_if_the_series_has_not_been_started()
    {
        $user = $this->login();

        $series = factory(Series::class)->create();
        $lesson = factory(Lesson::class)->create([
            'series_id' => $series->id,
        ]);
        factory(Lesson::class, 5)->create();

        $this->get(
            route('series.show', [
                'series' => $series->slug,
            ])
        )->assertRedirect(
            route('lesson.show', [
                'series' => $series->slug,
                'lesson' => $lesson->slug,
            ])
        );
    }

    /** @test */
    public function it_redirects_to_the_first_lesson_if_no_lessons_have_been_completed()
    {
        $user = $this->login();

        $series = factory(Series::class)->create();
        $lesson = factory(Lesson::class)->create([
            'series_id' => $series->id,
        ]);
        factory(Activity::class)->create([
            'user_id' => $user->id,
            'item_id' => $lesson->id,
            'item_type' => Lesson::class,
            'type' => 'started',
        ]);
        factory(Lesson::class, 5)->create();

        $this->get(
            route('series.show', [
                'series' => $series->slug,
            ])
        )->assertRedirect(
            route('lesson.show', [
                'series' => $series->slug,
                'lesson' => $lesson->slug,
            ])
        );
    }

    /** @test */
    public function it_redirects_to_the_next_unfinished_lesson_if_the_series_has_been_started()
    {
        // Given
        $user = $this->login();
        $series = factory(Series::class)->create();
        $finished_lesson = factory(Lesson::class)->create([
            'series_id' => $series->id,
            'slug' => 'finished',
        ]);
        factory(Activity::class)->create([
            'user_id' => $user->id,
            'item_id' => $finished_lesson->id,
            'item_type' => Lesson::class,
            'type' => 'finished',
        ]);

        $unfinished_lesson = factory(Lesson::class)->create([
            'series_id' => $series->id,
            'slug' => 'unfinished',
        ]);

        $this->get(
            route('series.show', [
                'series' => $series->slug,
            ])
        )->assertRedirect(
            route('lesson.show', [
                'series' => $series->slug,
                'lesson' => $unfinished_lesson->slug,
            ])
        );
    }

    /** @test */
    public function it_redirects_to_the_first_lesson_if_the_series_has_been_completed()
    {
        $user = $this->login();

        $series = factory(Series::class)->create();
        $lesson = factory(Lesson::class)->create([
            'series_id' => $series->id,
        ]);
        factory(Lesson::class, 2)->create([
            'series_id' => $series->id,
        ]);

        Lesson::all()->each(function ($lesson) use ($user) {
            factory(Activity::class)->create([
                'user_id' => $user->id,
                'item_id' => $lesson->id,
                'item_type' => Lesson::class,
                'type' => 'finished',
            ]);
        });

        $this->get(
            route('series.show', [
                'series' => $series->slug,
            ])
        )->assertRedirect(
            route('lesson.show', [
                'series' => $series->slug,
                'lesson' => $lesson->slug,
            ])
        );
    }

}
