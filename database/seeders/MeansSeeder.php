<?php
/**
  *-------------------------------------------------------------------------------------
  * Developer Information
  *-------------------------------------------------------------------------------------
  * @author Isaac Daniel Batista <daniel@danielbat.com>
  * @link https://danielbat.com Web Autor's site
  * @see https://twitter.com/codeisaac <@codeisaac>
  * @copyright 2020
  * @version 1.0.0
  * @package App\
  * Type: Seeder
  * Description: Description
  *
  * For the full copyright and license information, please view the LICENSE
  * file that was distributed with this source code.
  */

namespace Database\Seeders;

use App\Models\Means;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

/** @psalm-suppress PossiblyUnusedMethod */
class MeansSeeder extends Seeder
{
    /**
     * Run the database seeders.
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
