<?php

namespace Database\Factories;

use App\Models\Means;
use Illuminate\Database\Eloquent\Factories\Factory;

class SourceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'      => $this->faker->text(6),
            'company'   => $this->faker->text(20),
            'comment'   => $this->faker->text(),
            'active'    => 1,
            'coverage'  => 'Local',
            'means_id'  => Means::all()->random()->id
        ];
    }
}
