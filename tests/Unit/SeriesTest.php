<?php

namespace Tests\Unit;

use App\User;
use App\Lesson;
use App\Series;
use App\Activity;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SeriesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_many_lessons()
    {
        $series = factory(Series::class)->create();
        factory(Lesson::class, 5)->create([
            'series_id' => $series->id,
        ]);

        $this->assertInstanceOf(Collection::class, $series->lessons);
    }

    /** @test */
    public function it_knows_if_its_started_for_the_user()
    {
        // Given
        $user = $this->login();
        $series_new = factory(Series::class)->create();
        $series_started = factory(Series::class)->create();
        $lesson = factory(Lesson::class)->create([
            'series_id' => $series_started->id,
        ]);
        factory(Activity::class)->create([
            'user_id' => $user->id,
            'item_id' => $lesson->id,
            'item_type' => Lesson::class,
        ]);

        // Then
        $this->assertFalse($series_new->hasStarted());
        $this->assertTrue($series_started->hasStarted());
    }

}
