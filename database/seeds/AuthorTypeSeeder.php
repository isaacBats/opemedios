<?php

use App\AuthorType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AuthorTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AuthorType::insert([
            ['description' => 'Conductor', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['description' => 'Invitado', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['description' => 'Reportero', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['description' => 'Colaborador', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['description' => 'Editor', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['description' => 'Otro', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
