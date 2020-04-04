<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Lesson;
use App\Resource;
use Faker\Generator as Faker;

$factory->define(Resource::class, function (Faker $faker) {
    return [
        'title' => $faker->words(3, true),
        'url' => $faker->url(),
        'lesson_id' => factory(Lesson::class)->create()->id,
    ];
});
