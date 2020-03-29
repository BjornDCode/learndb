<?php

namespace Tests\Feature\Series;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SeriesIndexTest extends TestCase
{

    /** @test */
    public function it_shows_the_library_page()
    {
        $response = $this->get('/library');

        $response->assertStatus(200);
        $response->assertInertiaViewIs('Series/Index');
    }

}
