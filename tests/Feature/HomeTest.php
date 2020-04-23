<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function unathenticated_users_cannot_go_to_the_home_page()
    {
        $this->withExceptionHandling();

        $this->get(route('home'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function it_redirects_to_the_library_page()
    {
        $this->login();

        $this->get(route('home'))
            ->assertRedirect(route('library'));
    }

}
