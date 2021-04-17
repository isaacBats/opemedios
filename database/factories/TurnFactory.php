<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Turn;
use Faker\Generator as Faker;

$factory->define(Turn::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(4, false),
        'description' => $faker->paragraph
    ];
});
