<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Lesson;
use App\Activity;
use Faker\Generator as Faker;

$factory->define(Activity::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class)->create()->id,
        'item_id' => factory(Lesson::class)->create()->id,
        'item_type' => Lesson::class,
        'type' => 'started',
    ];
});
