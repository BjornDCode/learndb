<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Lesson;
use App\Series;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Lesson::class, function (Faker $faker) {
    $title = $faker->words(3, true);

    return [
        'title' => $title,
        'slug' => Str::slug($title),
        'series_id' => factory(Series::class)->create()->id,
    ];
});
