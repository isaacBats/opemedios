<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/** @psalm-suppress PossiblyUnusedMethod */
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(20)->create();
    }
}
