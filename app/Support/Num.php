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
  * Type: Support
  * Description: Description
  *
  * For the full copyright and license information, please view the LICENSE
  * file that was distributed with this source code.
  */
        
namespace App\Support;

class Num 
{

    protected static $format_decimal;
    
    protected static $format_coin;

    const static LOCALE = 'es_MX';

    public function __construct() {
        $this->format_coin = numfmt_create(static::LOCALE, \NumberFormatter::CURRENCY);
        $this->format_decimal = numfmt_create(static::LOCALE, \NumberFormatter::DECIMAL);
    }

    public static function formatNumber($number) {
        return numfmt_format($this->format_decimal, $number);
    }

    public static function formatCoin($number) {
        return numfmt_format($this->format_coin, $number);
    } 
}