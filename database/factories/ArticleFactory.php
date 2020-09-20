<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Model;
use App\Article;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'title' => $faker->text(50),
        'body' => $faker->text(200),
        'excerpt' => $faker->text(125),
        'user_id' => factory(User::class)
    ];
});
