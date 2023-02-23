<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

namespace Database\Factories;

use App\Company;
use App\Theme;
use Faker\Generator as Faker;

$factory->define(Theme::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(2, false),
        'description' => $faker->paragraph,
        'company_id' => Company::all()->random()->id
    ];
});
