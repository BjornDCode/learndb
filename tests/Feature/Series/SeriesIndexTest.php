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

        $this->get('/library')
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function it_shows_the_library_page()
    {
        $this->login();

        $this->get('/library')
            ->assertStatus(200)
            ->assertInertiaViewIs('Series/Index');
    }

    /** @test */
    public function it_shows_all_series()
    {
        $this->login();
        
        factory(Series::class, 5)->create();
        $first_series = Series::first();

        $this->get('/library')
            ->assertPropCount('series', 5)
            ->assertJsonFragmentInProp('series', [
                'id' => $first_series->id,
                'title' => $first_series->title,
                'description' => $first_series->description,
                'image' => $first_series->image,
            ]);
    }

}
