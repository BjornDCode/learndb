<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Lesson;
use App\Series;
use App\Article;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Lesson::class, function (Faker $faker) {
    $title = $faker->words(3, true);

    return [
        'title' => $title,
        'slug' => Str::slug($title),
        'description' => $faker->text,
        'content_type' => Article::class,
        'content_id' => factory(Article::class)->create()->id, 
        'series_id' => factory(Series::class)->create()->id,
    ];
});
