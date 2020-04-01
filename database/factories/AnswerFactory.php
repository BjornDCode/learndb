<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Answer;
use App\Option;
use Faker\Generator as Faker;

$factory->define(Answer::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class)->create()->id,
        'option_id' => factory(Option::class)->create()->id,
    ];
});
