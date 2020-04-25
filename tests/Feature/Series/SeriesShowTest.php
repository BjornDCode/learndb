<?php

namespace Tests\Feature\Series;

use App\Lesson;
use App\Series;
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

}
