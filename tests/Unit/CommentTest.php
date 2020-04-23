<?php

namespace Tests\Unit;

use App\User;
use App\Comment;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_an_author()
    {
        $comment = factory(Comment::class)->create();

        $this->assertInstanceOf(User::class, $comment->author);
    }

    /** @test */
    public function it_can_be_nested()
    {
        $parent = factory(Comment::class)->create();
        $child = factory(Comment::class)->create([
            'parent_id' => $parent->id,
        ]);

        $this->assertInstanceOf(Collection::class, $parent->children);
        $this->assertInstanceOf(Comment::class, $parent->children->first());
        $this->assertInstanceOf(Comment::class, $child->parent);
    }

}
