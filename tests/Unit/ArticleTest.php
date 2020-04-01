<?php

namespace Tests\Unit;

use App\Article;
use Faker\Factory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_returns_its_type()
    {
        $article = factory(Article::class)->create();

        $this->assertEquals('Article', $article->type);
    }

    /** @test */
    public function an_article_can_calculate_its_duration()
    {
        $faker = Factory::create();

        $short_article = factory(Article::class)->create([
            'content' => $faker->words(450, true)
        ]);

        $long_article = factory(Article::class)->create([
            'content' => $faker->words(1150, true)
        ]);

        $this->assertEquals('2 min', $short_article->duration);
        $this->assertEquals('6 min', $long_article->duration);
    }

}
