<?php

namespace Database\Seeders;

use App\Source;
use Illuminate\Database\Seeder;

class SourceSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        factory(Source::class, 30)->create();
    }
}
