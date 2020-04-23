<?php

namespace Tests\Feature;

use App\Lesson;
use App\Comment;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $lesson = factory(Lesson::class)->create();

        $this->lessonRoute = route('lesson.show', [$lesson->series->slug, $lesson->slug]);
        $this->commentRoute = route('comment.store', [$lesson->series->slug, $lesson->slug]);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_leave_comments()
    {
        $this->withExceptionHandling();

        $this->post($this->commentRoute)
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function content_is_required()
    {
        $this->withExceptionHandling();

        $this->login();

        $this->from($this->lessonRoute)
            ->post($this->commentRoute)
            ->assertRedirect($this->lessonRoute);
    }

    /** @test */
    public function either_a_parent_or_a_lesson_is_required()
    {
        $this->withExceptionHandling();

        $this->login();

        $this->from($this->lessonRoute)
            ->post($this->commentRoute, [
                'content' => 'This is my comment'
            ])
            ->assertRedirect($this->lessonRoute);
    }

    /** @test */
    public function the_lesson_must_exist_if_its_a_top_level_comment()
    {
        $this->withExceptionHandling();

        $this->login();

        $this->from($this->lessonRoute)
            ->post($this->commentRoute, [
                'content' => 'This is my comment',
                'lesson_id' => 'non-existing',
                'parent_id' => factory(Comment::class)->create()->id,
            ])
            ->assertRedirect($this->lessonRoute);
    }

    /** @test */
    public function the_comment_must_exist_if_its_a_nested_comment()
    {
        $this->withExceptionHandling();

        $this->login();

        $this->from($this->lessonRoute)
            ->post($this->commentRoute, [
                'content' => 'This is my comment',
                'parent_id' => 'non-existing',
                'lesson_id' => factory(Lesson::class)->create()->id,
            ])
            ->assertRedirect($this->lessonRoute);
    }

    /** @test */
    public function a_user_can_leave_a_top_level_comment()
    {
        $this->login();

        $lesson = factory(Lesson::class)->create();

        $this->from($this->lessonRoute)
            ->post($this->commentRoute, [
                'content' => 'This is my comment',
                'lesson_id' => $lesson->id,
            ])
            ->assertRedirect($this->lessonRoute);

        $this->assertDatabaseHas('comments', [
            'content' => 'This is my comment',
            'lesson_id' => $lesson->id,
            'parent_id' => null,
        ]);
    }

    /** @test */
    public function a_user_can_leave_a_nested_comment()
    {
        $this->login();
        
        $parent = factory(Comment::class)->create();

        $this->from($this->lessonRoute)
            ->post($this->commentRoute, [
                'content' => 'This is my comment',
                'parent_id' => $parent->id,
            ])
            ->assertRedirect($this->lessonRoute);

        $this->assertDatabaseHas('comments', [
            'content' => 'This is my comment',
            'lesson_id' => null,
            'parent_id' => $parent->id,
        ]);
    }

}
