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
    const STR_LOCALE = 'es_MX';

    private static function setFormat($formatter) {
        return numfmt_create(self::STR_LOCALE, $formatter);
    } 

    public static function formatNumber($number) {
        $format = self::setFormat(\NumberFormatter::DECIMAL);
        return numfmt_format($format, $number);
    }

    public static function formatCoin($number) {
        $format = self::setFormat(\NumberFormatter::CURRENCY);
        return numfmt_format($format, $number);
    } 
}