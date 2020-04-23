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

    /** @test */
    public function it_can_generate_an_email_hash()
    {
        $comment1 = factory(Comment::class)->create();
        $comment2 = factory(Comment::class)->create();
        $comment3 = factory(Comment::class)->create();

        $comment1->author->update([
            'email' => '  comment1@example.com  ',
        ]);
        $comment2->author->update([
            'email' => 'COMMENT2@example.com',
        ]);
        $comment3->author->update([
            'email' => 'comment3@example.com',
        ]);

        $this->assertEquals('e377cf791e6129a17e8b15c3acba1dc7', $comment1->generateEmailHash());
        $this->assertEquals('5194707c796ebee0cdd6d12b16cb5d40', $comment2->generateEmailHash());
        $this->assertEquals('2e4021855cfba7aac19a0a9042397756', $comment3->generateEmailHash());
    }

}
