<?php
namespace TNkemdilim\MoneyToWords\Helpers;

class NumericSystem
{
    /**
     * Checks if the input specified is in greek numeric system 
     * i.e. contains digits between 0 - 9.
     * 
     * @param String $digit 
     * 
     * @return Bool
     */
    static function isGreek(String $digit)
    {
        // $strVal = strval($digit);
        // var_dump($strVal == 'm/[^a-zA-Z0-9]/');
        // $numbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        // return in_array($strVal[0], $numbers) && $strVal == 'm/[^a-zA-Z0-9]/';
        return is_numeric($digit);
    }
}
