<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchTest extends TestCase
{

    /** @test */
    public function the_query_is_required()
    {
        $this->withExceptionHandling();

        $response = $this->getJson('api/search');

        $response->assertStatus(422);
    }

}
