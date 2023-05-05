<?php

namespace Database\Seeders;

use App\Models\NewsletterLinksCovers;
use Illuminate\Database\Seeder;

class NewsletterLinksCoversSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NewsletterLinksCovers::factory(3)->create();
    }
}
