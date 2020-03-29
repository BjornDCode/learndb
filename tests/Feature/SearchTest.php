<?php

namespace Tests\Feature;

use App\Series;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_query_is_required()
    {
        $this->withExceptionHandling();

        $response = $this->getJson('api/search');

        $response->assertStatus(422);
    }

    /** @test */
    public function it_can_search_for_series_title()
    {
        $series = factory(Series::class)->create([
            'title' => 'My series title'
        ]);
        factory(Series::class)->create();

        $response = $this->getJson('api/search?query=title');

        $response->assertJsonCount(1);
        $response->assertJsonFragment([
            'type' => 'series',
            'title' => 'My series title',
            'url' => route('series.show', [$series->slug])
        ]);
    }

}
