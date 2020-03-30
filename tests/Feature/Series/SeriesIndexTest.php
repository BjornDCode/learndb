<?php

namespace Tests\Feature\Series;

use App\Series;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SeriesIndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_shows_the_library_page()
    {
        $response = $this->get('/library');

        $response->assertStatus(200);
        $response->assertInertiaViewIs('Series/Index');
    }

    /** @test */
    public function it_shows_all_series()
    {
        factory(Series::class, 5)->create();
        $first_series = Series::first();

        $response = $this->get('/library');

        $response->assertHasProp('series');
        $this->assertEquals(
            5, 
            count($response->props('series')),
        );
        $this->assertJsonFragment($response->props(), [
            'id' => $first_series->id,
            'title' => $first_series->title,
            'description' => $first_series->description,
            'image' => $first_series->image,
        ]);
    }

}
