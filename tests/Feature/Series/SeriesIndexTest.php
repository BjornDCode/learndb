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

    /** @test */
    public function it_shows_progress_for_series_that_has_been_started()
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

        factory(Lesson::class, 5)->create([
            'series_id' => $series_new->id,
        ]);
        factory(Lesson::class, 4)->create([
            'series_id' => $series_started->id,
        ]);

        $this->get('/library')
            ->assertJsonFragmentInProp('series', [
                'id' => $series_new->id,
                'progress' => '5 lessons',
            ])
            ->assertJsonFragmentInProp('series', [
                'id' => $series_started->id,
                'progress' => '1/5 lessons',
            ]);
    }

    /** @test */
    public function it_shows_the_users_current_series()
    {
        $user = $this->login();
        
        factory(Series::class, 5)->create();
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
            ->assertPropCount('current_series', 1)
            ->assertJsonFragmentInProp('current_series', [
                'id' => $series_started->id,
                'title' => $series_started->title,
                'description' => $series_started->description,
                'image' => $series_started->image,
            ]);
    }

}
