<?php

namespace Database\Factories;

use App\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class ThemeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(2, false),
            'description' => $this->faker->paragraph,
            'company_id' => Company::all()->random()->id
        ];
    }
}
