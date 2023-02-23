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

use App\Genre;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        Genre::insert([
            ['description' => 'Reportaje', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['description' => 'Artículo', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['description' => 'Noticia', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['description' => 'Entrevista', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['description' => 'Editorial', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['description' => 'Publireportaje', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['description' => 'Columna Política', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['description' => 'Columna Financiera', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['description' => 'Fotografía', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['description' => 'Otro', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['description' => 'Promociones', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
