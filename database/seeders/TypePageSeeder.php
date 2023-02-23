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

use App\TypePage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class TypePageSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        TypePage::insert([
            ['description' => 'Portada', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['description' => 'Contraportada', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['description' => 'Par', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['description' => 'Impar', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
