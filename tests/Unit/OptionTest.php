<?php

namespace Tests\Unit;

use App\User;
use App\Answer;
use App\Option;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;


class OptionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_users()
    {
        $user = factory(User::class)->create();
        $option = factory(Option::class)->create();        

        factory(Answer::class)->create([
            'user_id' => $user->id,
            'option_id' => $option->id,
        ]);

        $this->assertInstanceOf(Collection::class, $option->users);
        $this->assertInstanceOf(User::class, $option->users->first());
    }

    /** @test */
    public function it_knows_if_it_has_been_answered_by_the_user()
    {
        $user = $this->login();
        $option = factory(Option::class)->create();
        factory(Answer::class)->create([
            'user_id' => $user->id,
            'option_id' => $option->id,
        ]);

        $this->assertEquals(true, $option->hasBeenAnsweredByUser());
    }

}
