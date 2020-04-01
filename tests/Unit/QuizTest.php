<?php

namespace Tests\Unit;

use App\Quiz;
use App\User;
use App\Answer;
use App\Option;
use App\Question;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuizTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_returns_its_type()
    {
        $quiz = factory(Quiz::class)->create();

        $this->assertEquals('Quiz', $quiz->type);
    }

    /** @test */
    public function it_has_questions()
    {
        $quiz = factory(Quiz::class)->create();
        factory(Question::class, 2)->create([
            'quiz_id' => $quiz->id,
        ]);

        $this->assertInstanceOf(Collection::class, $quiz->questions);
        $this->assertInstanceOf(Question::class, $quiz->questions->first());
    }

    /** @test */
    public function it_can_calculate_its_duration()
    {
        $user = $this->login();
        $quiz = factory(Quiz::class)->create();
        factory(Question::class, 3)->create([
            'quiz_id' => $quiz->id,
        ]);
        $question = Question::first();

        factory(Option::class, 2)->create([
            'question_id' => $question->id,
        ]);
        $option = Option::first();

        factory(Answer::class)->create([
            'user_id' => $user->id,
            'option_id' => $option->id,
        ]);

        $this->assertEquals('1/3 questions', $quiz->duration);
    }

}
