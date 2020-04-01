<?php

namespace Tests\Unit;

use App\Lesson;
use App\Series;
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
}
