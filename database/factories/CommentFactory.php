<?php

use Faker\Generator as Faker;

$factory->define(App\Comment::class, function (Faker $faker) {
    return [
      'user_id' => User::find(array_rand(User::pluck('id')->toArray()))->id,
      'post_id' => Post::find(array_rand(Post::pluck('id')->toArray()))->id,
      'body' => $faker->paragraphs(rand(1, 2), true),
    ];
});
