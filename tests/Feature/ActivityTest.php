<?php

namespace Tests\Feature;

use App\Lesson;
use App\Activity;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_records_when_a_lesson_is_started()
    {
        // Given 
        $user = $this->login();
        $lesson = factory(Lesson::class)->create();

        // When 
        $this->get(
            route('lesson.show', [
                'series' => $lesson->series->slug,
                'lesson' => $lesson->slug,
            ])
        );

        // Then 
        $this->assertDatabaseHas('activities', [
            'user_id' => $user->id,
            'item_id' => $lesson->id,
            'item_type' => Lesson::class,
            'type' => 'started',
        ]);
    }

    /** @test */
    public function it_only_records_when_lesson_is_started_once()
    {
        $user = $this->login();
        $lesson = factory(Lesson::class)->create();
        factory(Activity::class)->create([
            'user_id' => $user->id,
            'item_id' => $lesson->id,
            'item_type' => Lesson::class,
            'type' => 'started'
        ]);

        $this->get(
            route('lesson.show', [
                'series' => $lesson->series->slug,
                'lesson' => $lesson->slug,
            ])
        );

        $this->assertDatabaseHas('activities', [
            'user_id' => $user->id,
            'item_id' => $lesson->id,
            'item_type' => Lesson::class,
            'type' => 'started',
        ]);
        $this->assertCount(1, Activity::all());
    }

    /** @test */
    public function it_can_record_when_a_lesson_is_finished()
    {
        $user = $this->login();
        $lesson = factory(Lesson::class)->create();

        $response = $this->from(
                route('lesson.show', [$lesson->series->slug, $lesson->slug])
            )
            ->postJson(
                route('activity.store', [
                    'user_id' => $user->id,
                    'item_id' => $lesson->id,
                    'item_type' => Lesson::class,
                    'type' => 'finished',
                ])
            );

        $response->assertRedirect(
            route('lesson.show', [$lesson->series->slug, $lesson->slug])
        );

        $this->assertDatabaseHas('activities', [
            'user_id' => $user->id,
            'item_id' => $lesson->id,
            'item_type' => Lesson::class,
            'type' => 'finished',
        ]);
    }

    /** @test */
    public function it_only_records_when_lesson_is_finished_once()
    {
        $user = $this->login();
        $lesson = factory(Lesson::class)->create();
        factory(Activity::class)->create([
            'user_id' => $user->id,
            'item_id' => $lesson->id,
            'item_type' => Lesson::class,
            'type' => 'finished'
        ]);

        $this->postJson(
                route('activity.store', [
                    'user_id' => $user->id,
                    'item_id' => $lesson->id,
                    'item_type' => Lesson::class,
                    'type' => 'finished',
                ])
            );

        $this->assertDatabaseHas('activities', [
            'user_id' => $user->id,
            'item_id' => $lesson->id,
            'item_type' => Lesson::class,
            'type' => 'finished',
        ]);
        $this->assertCount(1, Activity::all());
    }

}
