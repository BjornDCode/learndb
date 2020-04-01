<?php

namespace Tests\Feature\Lessons;

use App\Quiz;
use App\Video;
use App\Answer;
use App\Lesson;
use App\Option;
use App\Series;
use App\Article;
use App\Question;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LessonShowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function unauthenticated_users_cannot_see_the_lesson_page()
    {
        $this->withExceptionHandling();

        $lesson = factory(Lesson::class)->create();

        $this->get(
            route('lesson.show', [
                'series' => $lesson->series->slug,
                'lesson' => $lesson->slug,
            ])
        )
        ->assertRedirect(route('login'));
    }

    /** @test */
    public function authenticated_users_can_see_the_lesson_page()
    {
        $this->login();

        $lesson = factory(Lesson::class)->create();

        $this->get(
            route('lesson.show', [
                'series' => $lesson->series->slug,
                'lesson' => $lesson->slug,
            ])
        )
        ->assertStatus(200)
        ->assertInertiaViewIs('Lesson/Show');
    }

    /** @test */
    public function the_lesson_must_belong_to_the_series()
    {
        $this->withExceptionHandling();
        $this->login();

        $lesson = factory(Lesson::class)->create();
        $series = factory(Series::class)->create();

        $this->get(
            route('lesson.show', [
                'series' => $series->slug,
                'lesson' => $lesson->slug,
            ])
        )->assertStatus(404);
    }

    /** @test */
    public function it_returns_the_lesson_details()
    {
        $this->login();

        $lesson = factory(Lesson::class)->create();

        $this->get(
            route('lesson.show', [
                'series' => $lesson->series->slug,
                'lesson' => $lesson->slug,
            ])
        )
        ->assertJsonFragmentInProp('lesson', [
            'id' => $lesson->id,
            'title' => $lesson->title,
            'description' => $lesson->description,
        ]);
    }    

    /** @test */
    public function it_returns_an_article_lesson()
    {
        $this->login();

        $article = factory(Article::class)->create();
        $lesson = factory(Lesson::class)->create([
            'content_type' => Article::class,
            'content_id' => $article->id,
        ]);

        $this->get(
            route('lesson.show', [
                'series' => $lesson->series->slug,
                'lesson' => $lesson->slug,
            ])
        )
        ->assertJsonFragmentInProp('lesson', [
            'content' => [
                'id' => $article->id,
                'title' => $article->title,
                'content' => $article->content,
                'duration' => $article->duration,
                'type' => $article->type,
            ]
        ]);
    }

    /** @test */
    public function it_returns_a_video_lesson()
    {
        $this->login();

        $video = factory(Video::class)->create();
        $lesson = factory(Lesson::class)->create([
            'content_type' => Video::class,
            'content_id' => $video->id,
        ]);

        $this->get(
            route('lesson.show', [
                'series' => $lesson->series->slug,
                'lesson' => $lesson->slug,
            ])
        )
        ->assertJsonFragmentInProp('lesson', [
            'content' => [
                'id' => $video->id,
                'title' => $video->title,
                'description' => $video->description,
                'url' => $video->url,
                'duration' => $video->duration,
                'type' => $video->type,
            ]
        ]);
    }    

    /** @test */
    public function it_returns_a_quiz_lesson()
    {
        $user = $this->login();

        $quiz = factory(Quiz::class)->create();
        $question = factory(Question::class)->create([
            'quiz_id' => $quiz->id,
        ]);
        $correct_option = factory(Option::class)->create([
            'question_id' => $question->id,
            'correct' => true,
        ]);
        $wrong_option = factory(Option::class)->create([
            'question_id' => $question->id,
            'correct' => false,
        ]);
        factory(Answer::class)->create([
            'user_id' => $user->id,
            'option_id' => $correct_option->id,
        ]);

        $lesson = factory(Lesson::class)->create([
            'content_type' => Quiz::class,
            'content_id' => $quiz->id,
        ]);

        $this->get(
            route('lesson.show', [
                'series' => $lesson->series->slug,
                'lesson' => $lesson->slug,
            ])
        )
        ->assertJsonFragmentInProp('lesson', [
            'content' => [
                'id' => $quiz->id,
                'title' => $quiz->title,
                'duration' => $quiz->duration,
                'questions' => [
                    [
                        'id' => $question->id,
                        'title' => $question->title,
                        'options' => [
                            [
                                'id' => $correct_option->id,
                                'title' => $correct_option->title,
                                'correct' => $correct_option->correct,
                                'answered' => true,
                            ],
                            [
                                'id' => $wrong_option->id,
                                'title' => $wrong_option->title,
                                'correct' => $wrong_option->correct,
                                'answered' => false,
                            ]
                        ]
                    ]
                ],
            ]
        ]);
    }

    /** @test */
    public function it_returns_all_lessons_for_the_series()
    {
        $this->login();

        $lesson = factory(Lesson::class)->create();

        $lessons = factory(Lesson::class, 5)->create([
            'series_id' => $lesson->series->id,
        ]);

        $this->get(
            route('lesson.show', [
                'series' => $lesson->series->slug,
                'lesson' => $lesson->slug,
            ])
        )
        ->assertPropCount('lessons', 6)
        ->assertJsonFragmentInProp('lessons', [
            'id' => $lessons->first()->id,
            'title' => $lessons->first()->title,
            'description' => $lessons->first()->description,
        ]);
    }

}
