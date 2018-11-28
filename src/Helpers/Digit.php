<?php 

namespace TNkemdilim\MoneyToWords\Helpers;

class Digit
{
    /**
     * Determines if a given numeric value is a decimal.
     *
     * @param String|Numeric $value Value to check if decimal
     * 
     * @return boolean
     */
    static function isDecimal($value)
    {
        return strstr(strval($value), '.');
    }
}