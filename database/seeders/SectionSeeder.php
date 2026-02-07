<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;

/** @psalm-suppress PossiblyUnusedMethod */
class SectionSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        Section::factory(30)->create();
    }
}
