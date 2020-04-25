<?php

namespace Tests\Feature;

use App\Lesson;
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

}
