<?php
/**
  *-------------------------------------------------------------------------------------
  * Developer Information
  *-------------------------------------------------------------------------------------
  * @author Isaac Daniel Batista <daniel@danielbat.com>
  * @link https://danielbat.com Web Autor's site
  * @see https://twitter.com/codeisaac <@codeisaac>
  * @copyright 2023
  * @version 1.0.0
  * @package App\Export\Sheets
  * Type: Sheet
  * Description: Class to generate pivot tables
  *
  * For the full copyright and license information, please view the LICENSE
  * file that was distributed with this source code.
  */
 
namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\{FromQuery,WithTitle};

class PivotTablesSheet implements FromQuery, WithTitle
{
    private $notesIds;

    public function __construct($notes)
    {
        $this->notes = $notes;
    }
    
    public function query()
    {
        return $this->notes;
    }

     /**
     * @return string
     */
    public function title(): string
    {
        return 'Tablas pivote';
    }
}
