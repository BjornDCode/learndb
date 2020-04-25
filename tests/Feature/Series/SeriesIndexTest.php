<?php

namespace Tests\Feature\Series;

use App\Lesson;
use App\Series;
use App\Activity;
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

    /** @test */
    public function it_shows_whether_series_are_started()
    {
        $user = $this->login();
        
        $series_new = factory(Series::class)->create();
        $series_started = factory(Series::class)->create();
        $lesson = factory(Lesson::class)->create([
            'series_id' => $series_started->id,
        ]);
        factory(Activity::class)->create([
            'user_id' => $user->id,
            'item_id' => $lesson->id,
            'item_type' => Lesson::class,
        ]);

        $this->get('/library')
            ->assertJsonFragmentInProp('series', [
                'id' => $series_new->id,
                'started' => false,
            ])
            ->assertJsonFragmentInProp('series', [
                'id' => $series_started->id,
                'started' => true,
            ]);
    }

}
