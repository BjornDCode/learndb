<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Video;
use Faker\Generator as Faker;

$factory->define(Video::class, function (Faker $faker) {
    return [
        'title' => $faker->words(3, true),
        'description' => $faker->text,
        'url' => 'https://player.vimeo.com/video/175883915',
        'duration' => '01:24 min',
    ];
});
