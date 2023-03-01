<?php

namespace Database\Factories;

use App\Turn;
use Illuminate\Database\Eloquent\Factories\Factory;

class TurnFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(4, false),
            'description' => $this->faker->paragraph
        ];
    }
}
