<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Quiz;
use App\Question;
use Faker\Generator as Faker;

$factory->define(Question::class, function (Faker $faker) {
    return [
        'title' => $faker->words(3, true),
        'quiz_id' => factory(Quiz::class)->create()->id,
    ];
});
