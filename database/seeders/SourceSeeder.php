<?php

namespace Database\Seeders;

use App\Models\Source;
use Illuminate\Database\Seeder;

/** @psalm-suppress PossiblyUnusedMethod */
class SourceSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        Source::factory(30)->create();
    }
}
