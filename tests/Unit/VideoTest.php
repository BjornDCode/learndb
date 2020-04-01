<?php

namespace Tests\Unit;

use App\Video;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VideoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_returns_its_type()
    {
        $video = factory(Video::class)->create();

        $this->assertEquals('Video', $video->type);
    }

}
