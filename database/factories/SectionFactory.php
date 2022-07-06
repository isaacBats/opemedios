<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Section;
use App\Source;
use Faker\Generator as Faker;

$factory->define(Section::class, function (Faker $faker) {
    return [
        'name'          => $faker->word(),
        'author'        => $faker->name(),
        'description'   => $faker->text(),
        'active'        => 1,
        'source_id'     => Source::all()->random()->id,
    ];
});
