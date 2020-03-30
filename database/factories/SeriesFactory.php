<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Series;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Series::class, function (Faker $faker) {

    $title = $faker->words(3, true);

    return [
        'title' => $title,
        'slug' => Str::slug($title),
        'description' => $faker->text,
        'image' => '/storage/series_images/placeholder.png',
    ];
});
