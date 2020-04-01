<?php

namespace Tests\Unit;

use App\Option;
use App\Question;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;


class QuestionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_options()
    {
        $question = factory(Question::class)->create();
        factory(Option::class, 2)->create([
            'question_id' => $question->id,
        ]);

        $this->assertInstanceOf(Collection::class, $question->options);
        $this->assertInstanceOf(Option::class, $question->options->first());
    }

}
