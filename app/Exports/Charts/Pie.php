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
  * @package App\Export\Charts
  * Type: Chart
  * Description: Class to generate pie charts
  *
  * For the full copyright and license information, please view the LICENSE
  * file that was distributed with this source code.
  */
 
 namespace App\Exports\Charts;
 
class Pie
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
    
    public function generate()
    {
        return null;
    }
}
