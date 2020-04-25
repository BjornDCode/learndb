<?php

namespace Tests\Unit;

use App\User;
use App\Answer;
use App\Option;
use App\Activity;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;


class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_option_answers()
    {
        $user = factory(User::class)->create();
        factory(Answer::class)->create([
            'user_id' => $user->id,
        ]);

        $this->assertInstanceOf(Collection::class, $user->answers);
        $this->assertInstanceOf(Option::class, $user->answers->first());
    }

    /** @test */
    public function it_has_activities()
    {
        $user = factory(User::class)->create();
        factory(Activity::class)->create([
            'user_id' => $user->id,
        ]);

        $this->assertInstanceOf(Collection::class, $user->activities);
        $this->assertInstanceOf(Activity::class, $user->activities->first());
    }

}
