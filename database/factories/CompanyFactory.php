<?php

namespace Database\Factories;

use App\Turn;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CompanyFactory extends Factory
{

    public function definition(): array
    {
        $name = $this->faker->sentence(3, false);
        $slug = Str::slug($name);
        $turn = Turn::factory()->create();
        return [
            'name' => $name,
            'address' => $this->faker->address(),
            'slug' => $slug,
            'logo' => 'company_logos/uP5iSyzfNItdi70xx4WrdYnqEDRkHNp1wVwcdKv6.png',
            'turn_id' => $turn->id
        ];
    }
}

