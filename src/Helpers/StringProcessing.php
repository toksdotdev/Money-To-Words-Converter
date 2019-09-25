<?php

namespace TNkemdilim\MoneyToWords\Helpers;

class StringProcessing
{
    /**
     * Checks if a string ends with
     *
     * @param [type] $haystack
     * @param [type] $needle
     * @param boolean $case
     * @return void
     */
    public static function endsWith($haystack, $needle, $case = true)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }

    /**
     * Prefix a given string with a fixed amount of zero.
     * 
     * @param String  $stringVal    String to prefix
     * @param Integer $numberOfZero Number Of Zero Prefixes
     * 
     * @return String String of length divisible by 3
     */
    private static function _prefixWithZero(String $stringVal, int $numberOfZero)
    {
        $prefix = "";
        for ($i = 0; $i < $numberOfZero; $i++) {
            $prefix .= '0';
        }

        return "{$prefix}{$stringVal}";
    }

    /**
     * Split a string into an array of size 3. If the string length isn't 
     * dividible by 3, it is prefixed with zero to fill up the remainder.
     * 
     * @param String $stringVal String to split
     * 
     * @return Array
     */
    public static function splitIntoArrayOfSizeThree(String $stringVal)
    {
        if (strlen($stringVal) % 3 != 0) {
            // Makes string length a factor of 3.
            $stringVal = self::_prefixWithZero(
                $stringVal,
                3 - (strlen($stringVal) % 3)
            );
        }

        $size = strlen($stringVal);
        $colletion = array();

        for ($i = 0; $i < $size; $i += 3) {
            $firstDigit = "";
            $secondDigit = "";
            $thirdDigit = "";

            if ((!empty($stringVal[$i])) || ($stringVal[$i] == 0)) {
                $firstDigit = $stringVal[$i];
            }

            if ((!empty($stringVal[$i + 1])) || ($stringVal[$i + 1] == 0)) {
                $secondDigit = $stringVal[$i + 1];
            }

            if ((!empty($stringVal[$i + 2])) || ($stringVal[$i + 2] == 0)) {
                $thirdDigit = $stringVal[$i + 2];
            }

            array_push(
                $colletion,
                [intval($firstDigit), intval($secondDigit), intval($thirdDigit)]
            );
        }

        return $colletion;
    }
}
