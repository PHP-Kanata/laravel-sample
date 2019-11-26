<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Note;
use App\User;
use Faker\Generator as Faker;

$factory->define(Note::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(2),
        'content' => $faker->sentence(15),
        'user_id' => factory(User::class)->create()->id,
    ];
});
