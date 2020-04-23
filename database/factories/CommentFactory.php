<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'content' => $faker->words(10, true),
        'author_id' => factory(User::class)->create()->id,
    ];
});
