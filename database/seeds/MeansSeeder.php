<?php

use App\Means;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class MeansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Means::insert([
            ['created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'name' => 'Televisión', 'slug' => 'television', 'short_name' => 'tel', 'icon' => 'fa-television',],
            ['created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'name' => 'Radio', 'slug' => 'radio', 'short_name' => 'rad', 'icon' => 'fa-microphone',],
            ['created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'name' => 'Periódico', 'slug' => 'periodico', 'short_name' => 'per', 'icon' => 'fa-newspaper-o',],
            ['created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'name' => 'Revista', 'slug' => 'revista', 'short_name' => 'rev', 'icon' => 'fa-columns',],
            ['created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'name' => 'Internet', 'slug' => 'internet', 'short_name' => 'int', 'icon' => 'fa-chrome',],
        ]);
    }
}
