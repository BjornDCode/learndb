<?php

namespace Tests\Feature;

use App\Quiz;
use App\Lesson;
use App\Option;
use App\Question;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuizTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $lesson = factory(Lesson::class)->create();

        $this->lessonRoute = route('lesson.show', [$lesson->series->slug, $lesson->slug]);
        $this->answerRoute = route('answers.store', [$lesson->series->slug, $lesson->slug]);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_answer_questions()
    {
        $this->withExceptionHandling();

        $this->post($this->answerRoute)
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_option_is_required()
    {
        $this->withExceptionHandling();

        $this->login();

        $this->from($this->lessonRoute)
            ->post($this->answerRoute)
            ->assertRedirect($this->lessonRoute);;
    }

    /** @test */
    public function the_option_id_must_be_numeric()
    {
        $this->withExceptionHandling();

        $this->login();

        $lesson = factory(Lesson::class)->create();

        $this->from($this->lessonRoute)
            ->post($this->answerRoute, [
                'option_id' => 'yoyo'
            ])
            ->assertRedirect($this->lessonRoute);
    }

    /** @test */
    public function an_option_must_exist()
    {
        $this->withExceptionHandling();

        $this->login();

        $this->from($this->lessonRoute)
            ->post($this->answerRoute, [
                'option_id' => '2'
            ])
            ->assertRedirect($this->lessonRoute);
    }

    /** @test */
    public function a_user_can_answer_a_question()
    {
        $user = $this->login();

        $quiz = factory(Quiz::class)->create();
        $question = factory(Question::class)->create([
            'quiz_id' => $quiz->id,
        ]);
        $option = factory(Option::class)->create([
            'question_id' => $question->id,
        ]);
        $lesson = factory(Lesson::class)->create([
            'content_id' => $quiz->id,
            'content_type' => Quiz::class,
        ]);

        $this->post(
            route('answers.store', [$lesson->series->slug, $lesson->slug]), 
            [ 'option_id' => $option->id, ]
        )->assertRedirect(
            route('lesson.show', [$lesson->series->slug, $lesson->slug])
        );

        $this->assertDatabaseHas('answers', [
            'user_id' => $user->id,
            'option_id' => $option->id,
        ]);
    }

}
