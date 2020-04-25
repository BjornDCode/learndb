<?php

namespace Tests\Feature\Series;

use App\Series;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SeriesShowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function unauthenticated_users_cannot_hit_the_series_url()
    {
        $this->withExceptionHandling();

        $series = factory(Series::class)->create();

        $this->get(
            route('series.show', [
                'series' => $series->slug,
            ])
        )
        ->assertRedirect(route('login'));
    }

}
