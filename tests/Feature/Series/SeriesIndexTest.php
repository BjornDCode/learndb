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
    public function guest_users_can_not_access_the_library_page()
    {
        $this->withExceptionHandling();

        $response = $this->get('/library');

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function it_shows_the_library_page()
    {
        $this->login();

        $response = $this->get('/library');

        $response->assertStatus(200);
        $response->assertInertiaViewIs('Series/Index');
    }

    /** @test */
    public function it_shows_all_series()
    {
        $this->login();
        
        factory(Series::class, 5)->create();
        $first_series = Series::first();

        $response = $this->get('/library');

        $response->assertJsonFragmentInProp('series', [
            'id' => $first_series->id,
            'title' => $first_series->title,
            'description' => $first_series->description,
            'image' => $first_series->image,
        ]);
        $response->assertPropCount('series', 5);
    }

}
