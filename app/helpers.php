<?php

if (! function_exists('number_decimal')) {
    /**
     * @param  $number
     * @return object NumberFormatter or False 
     */
    function number_decimal($number) {
        return Num::formatNumber($number);
    }
}

if (! function_exists('number_coin')) {
    /**
     * @param  $number
     * @return object NumberFormatter or False 
     */
    function number_coin($number) {
        return Num::formatCoin($number);
    }
}