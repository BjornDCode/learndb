<?php

namespace Tests\Unit;

use App\Lesson;
use App\Series;
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
}
