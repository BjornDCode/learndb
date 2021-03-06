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
        $this->assertFalse($series_new->started);
        $this->assertTrue($series_started->started);
    }

    /** @test */
    public function it_knows_if_its_finished_for_the_user()
    {
        // Given
        $user = $this->login();
        $series_new = factory(Series::class)->create();
        $series_finished = factory(Series::class)->create();
        $lesson = factory(Lesson::class)->create([
            'series_id' => $series_finished->id,
        ]);
        factory(Activity::class)->create([
            'user_id' => $user->id,
            'item_id' => $lesson->id,
            'item_type' => Lesson::class,
            'type' => 'finished',
        ]);
        factory(Lesson::class, 5)->create([
            'series_id' => $series_new->id,
        ]);

        // Then
        $this->assertFalse($series_new->finished);
        $this->assertTrue($series_finished->finished);
    }

    /** @test */
    public function it_can_get_the_user_progress()
    {
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
            'type' => 'started',
        ]);
        factory(Activity::class)->create([
            'user_id' => $user->id,
            'item_id' => $lesson->id,
            'item_type' => Lesson::class,
            'type' => 'finished',
        ]);

        factory(Lesson::class, 5)->create([
            'series_id' => $series_new->id,
        ]);
        factory(Lesson::class, 4)->create([
            'series_id' => $series_started->id,
        ]);

        $this->assertEquals('5 lessons', $series_new->progress);
        $this->assertEquals('1/5 lessons', $series_started->progress);
    }

}
