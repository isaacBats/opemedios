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
