<?php

namespace TNkemdilim\MoneyToWords\Grammar;

class DigitDictionary
{
    /**
     * Converts the middle(2nd) digit [greate than or equal to 20] 
     * in the 3-size array to its corresponding tens as word.
     * 
     * @param Integer $digit Digit to convert to word
     * 
     * @return String
     */
    static function convertTensAndUnitDigit(String $digit)
    {
        if ($digit[0] == '0') {
            return self::convertUnitDigit($digit[1]);
        } else if ($digit[0] == '1') {
            return self::convertTensAndUnitDigitLessThan20($digit);
        }

        $unit = self::convertUnitDigit($digit[1]);
        if ($unit !== "" && $digit) {
            $unit = '-' . $unit;
        }

        return self::convertTensDigit($digit[0]) . $unit;
    }

    /**
     * Converts every first and last digit in the size 3 array 
     * to their corresponding word.
     * 
     * @param Integer $digit Digit to convert to word.
     * 
     * @return String
     */
    static function convertUnitDigit(int $digit)
    {
        $phrase = "";
        switch ($digit) {
            case '0':
                $phrase = "";
                break;
            case '1':
                $phrase = "one";
                break;
            case '2':
                $phrase = "two";
                break;
            case '3':
                $phrase = "three";
                break;
            case '4':
                $phrase = "four";
                break;
            case '5':
                $phrase = "five";
                break;
            case '6':
                $phrase = "six";
                break;
            case '7':
                $phrase = "seven";
                break;
            case '8':
                $phrase = "eight";
                break;
            case '9':
                $phrase = "nine";
                break;
            default:
                throw new \Exception("Invalid Input");
                break;
        }

        return $phrase;
    }

    /**
     * Converts the middle(2nd) digit [less than 20] in the size 3 array 
     * to its corresponding tens as word.
     * 
     * @param Integer $oneDigits Digit to convert to word
     * 
     * @return String
     */
    protected static function convertTensAndUnitDigitLessThan20(String $oneDigits)
    {
        $phrase = "";

        switch ($oneDigits) {
            case '10':
                $phrase = "ten";
                break;
            case '11':
                $phrase = "eleven";
                break;
            case '12':
                $phrase = "twelve";
                break;
            case '13':
                $phrase = "thirteen";
                break;
            case '14':
                $phrase = "fourteen";
                break;
            case '15':
                $phrase = "fifteen";
                break;
            case '16':
                $phrase = "sixteen";
                break;
            case '17':
                $phrase = "seventeen";
                break;
            case '18':
                $phrase = "eighteen";
                break;
            case '19':
                $phrase = "nineteen";
                break;
            default:
                throw new \Exception("Invalid Input");
                break;
        }

        return $phrase;
    }

    /**
     * Converts the middle(2nd) digit [greate than or equal to 20] 
     * in the 3-size array to its corresponding tens as word.
     * 
     * @param Integer $digit Digit to convert to word
     * 
     * @return String
     */
    protected static function convertTensDigit(int $digit)
    {
        $phrase = "";

        switch ($digit) {
            case '0':
                break;
            case '2':
                $phrase = "twenty";
                break;
            case '3':
                $phrase = "thirty";
                break;
            case '4':
                $phrase = "forty";
                break;
            case '5':
                $phrase = "fifty";
                break;
            case '6':
                $phrase = "sixty";
                break;
            case '7':
                $phrase = "seventy";
                break;
            case '8':
                $phrase = "eighty";
                break;
            case '9':
                $phrase = "ninety";
                break;
            default:
                throw new \Exception("Invalid Input");
                break;
        }

        return $phrase;
    }

    /**
     * Converts only the first digit in the 3-size array to its corresponding word
     * 
     * @param Integer $whichBlock Digit to convert to word
     * 
     * @return String
     */
    static function convertHundredthDigit(int $whichBlock)
    {
        $phrase = "";

        switch ($whichBlock) {
            case '0':
                $phrase = "";
                break;
            case '1':
                $phrase = "thousand";
                break;
            case '2':
                $phrase = "million";
                break;
            case '3':
                $phrase = "billion";
                break;
            case '4':
                $phrase = "trillion";
                break;
            default:
                throw new \Exception("Invalid Input");
                break;
        }

        return $phrase;
    }
}