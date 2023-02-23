<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

namespace Database\Factories;

use App\{Source, Means};
use Faker\Generator as Faker;

$factory->define(Source::class, function (Faker $faker) {
    return [
        'name'      => $faker->text(6),
        'company'   => $faker->text(20),
        'comment'   => $faker->text(),
        'active'    => 1,
        'coverage'  => 'Local',
        'means_id'  => Means::all()->random()->id
    ];
});
