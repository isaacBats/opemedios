<?php

namespace Database\Factories;

use App\Models\Source;
use Illuminate\Database\Eloquent\Factories\Factory;

class SectionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'          => $this->faker->word(),
            'author'        => $this->faker->name(),
            'description'   => $this->faker->text(),
            'active'        => 1,
            'source_id'     => Source::all()->random()->id,
        ];
    }
}
