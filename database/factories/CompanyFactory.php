<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\{Company, Turn};
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Company::class, function (Faker $faker) {
    $name = $faker->sentence(3, false);
    $slug = Str::slug($name);
    $turn = factory(Turn::class)->create();
    return [
        'name' => $name,
        'address' => $faker->address,
        'slug' => $slug,
        'logo' => 'company_logos/uP5iSyzfNItdi70xx4WrdYnqEDRkHNp1wVwcdKv6.png',
        'turn_id' => $turn->id
    ];
});
