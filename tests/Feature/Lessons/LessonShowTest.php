<?php

namespace Tests\Feature\Lessons;

use App\Quiz;
use App\Video;
use App\Answer;
use App\Lesson;
use App\Option;
use App\Series;
use App\Article;
use App\Comment;
use App\Activity;
use App\Question;
use App\Resource;
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
            'slug' => $lesson->slug,
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
                'type' => $quiz->type,
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

    /** @test */
    public function it_returns_activity_for_all_the_lessons()
    {
        $user = $this->login();

        $series = factory(Series::class)->create();
        $lesson_new = factory(Lesson::class)->create([
            'series_id' => $series->id,
        ]);
        $lesson_started = factory(Lesson::class)->create([
            'series_id' => $series->id,
        ]);

        $activity = factory(Activity::class)->create([
            'user_id' => $user->id,
            'item_id' => $lesson_started->id,
            'item_type' => Lesson::class,
            'type' => 'started'
        ]);

        $this->get(
            route('lesson.show', [
                'series' => $lesson_started->series->slug,
                'lesson' => $lesson_started->slug,
            ])
        )
        ->assertJsonFragmentInProp('lessons', [
            'id' => $lesson_new->id,
            'status' => null,
        ])
        ->assertJsonFragmentInProp('lessons', [
            'id' => $lesson_started->id,
            'status' => 'started',
        ]);
    }

    /** @test */
    public function it_returns_the_series()
    {
        $this->login();

        $lesson = factory(Lesson::class)->create();

        $this->get(
            route('lesson.show', [
                'series' => $lesson->series->slug,
                'lesson' => $lesson->slug,
            ])
        )
        ->assertJsonFragmentInProp('series', [
            'id' => $lesson->series->id,
            'title' => $lesson->series->title,
            'slug' => $lesson->series->slug,
            'description' => $lesson->series->description,
            'image' => $lesson->series->image,
        ]);
    }

    /** @test */
    public function it_returns_the_lesson_resources()
    {
        $this->login();

        $lesson = factory(Lesson::class)->create();
        $resource = factory(Resource::class)->create([
            'lesson_id' => $lesson->id,
        ]);

        $this->get(
            route('lesson.show', [
                'series' => $lesson->series->slug,
                'lesson' => $lesson->slug,
            ])
        )
        ->assertJsonFragmentInProp('resources', [
            [
                'title' => $resource->title,
                'url' => $resource->url,
            ]
        ]);
    }

    /** @test */
    public function it_returns_the_lesson_comments()
    {
        $this->login();

        $lesson = factory(Lesson::class)->create();
        $parent_comment = factory(Comment::class)->create([
            'lesson_id' => $lesson->id,
        ]);
        $nested_comment = factory(Comment::class)->create([
            'parent_id' => $parent_comment->id,
        ]);

        $response = $this->get(
            route('lesson.show', [
                'series' => $lesson->series->slug,
                'lesson' => $lesson->slug,
            ])
        );

        $response->assertJsonFragmentInProp('comments', [
            [
                'id' => $parent_comment->id,
                'content' => $parent_comment->content,
                'created_at' => $parent_comment->created_at->diffForHumans(),
                'author' => [
                    'name' => $parent_comment->author->name,
                    'email_hash' => $parent_comment->generateEmailHash(),
                ],
                'children' => [
                    [
                        'id' => $nested_comment->id,
                        'content' => $nested_comment->content,
                        'created_at' => $nested_comment->created_at->diffForHumans(),
                        'author' => [
                            'name' => $nested_comment->author->name,
                            'email_hash' => $nested_comment->generateEmailHash(),
                        ],
                        'children' => [],
                    ]
                ]
            ]
        ]);
    }

}
