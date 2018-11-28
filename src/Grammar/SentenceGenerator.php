<?php

namespace TNkemdilim\MoneyToWords\Grammar;

use TNkemdilim\MoneyToWords\Grammar\DigitDictionary;
use TNkemdilim\MoneyToWords\Helpers\StringProcessing as Str;

class SentenceGenerator
{
    /**
     * Convert a given money value in greek numbers to english sentence.
     *
     * @param String $moneyValue Money value to convert
     * 
     * @return String
     */
    public static function generateSentence($moneyValue)
    {
        $moneyValueArray = Str::splitIntoArrayOfSizeThree(strval(intval($moneyValue)));

        return self::_generateSentence($moneyValueArray);
    }

    /**
     * Convert a given money value whose already prepared into a set of 3.
     * e.g. [003,472,747], [045,532,453]
     * 
     * @param Array $moneyValueArray Money value in array to convert to words
     * 
     * @return String
     */
    private static function _generateSentence(array $moneyValueArray)
    {
        $sentence = "";
        $arraySize = count($moneyValueArray);
        for ($i = 0; $i < $arraySize; $i++) {
            $index = $arraySize - $i - 1;
            $groupValue = DigitDictionary::convertHundredthDigit($index);
            $hundredth = DigitDictionary::convertUnitDigit($moneyValueArray[$i][0]);
            $tensAndUnit = DigitDictionary::convertTensAndUnitDigit(
                $moneyValueArray[$i][1] . $moneyValueArray[$i][2]
            );

            if ($hundredth !== "") {
                $hundredth .= " hundred";
            }

            if ($tensAndUnit !== "" && $hundredth !== "") {
                $tensAndUnit = "and " . $tensAndUnit;
            }

            if ($hundredth == "") {
                $sentence .= "{$tensAndUnit} ";
            } else {
                $sentence .= "{$hundredth} {$tensAndUnit} ";
            }

            if ($groupValue != "") {
                $sentence .= $groupValue . ", ";
            }
        }

        return trim($sentence);
    }
}