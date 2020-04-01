<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Option;
use App\Question;
use Faker\Generator as Faker;

$factory->define(Option::class, function (Faker $faker) {
    return [
        'title' => $faker->words(3, true),
        'correct' => $faker->boolean,
        'question_id' => factory(Question::class)->create()->id,
    ];
});
