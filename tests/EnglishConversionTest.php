<?php

/**
 * Autoload files using Composer autoload
 */

use PHPUnit\Framework\TestCase;
use TNkemdilim\MoneyToWords\Converter;
use TNkemdilim\MoneyToWords\Languages as Language;

class EnglishConversionTest extends TestCase
{
    protected $converter;

    protected function setUp(): void
    {
        $this->converter = new Converter("naira", "kobo", Language::ENGLISH);
    }

    public function wholeNumberDataProvider()
    {
        return [
            ["345", "three hundred and forty-five naira only"],
            ["34", "thirty-four naira only"],
            ["23455", "twenty-three thousand, four hundred and fifty-five naira only"],
            ["345003", "three hundred and forty-five thousand, three naira only"],
            ["475923455", "four hundred and seventy-five million, nine hundred and twenty-three thousand, four hundred and fifty-five naira only"],
        ];
    }

    /**
     * @dataProvider wholeNumberDataProvider
     */
    public function testWholeNumber($wholeNumber, $expectedMessage)
    {
        $this->assertEquals(
            $expectedMessage,
            $this->converter->convert($wholeNumber)
        );
    }

    public function largeNumbersDataProvider()
    {
        return [
            ["50000000", "fifty million naira only"],
            ["900000000000", "nine hundred billion naira only"],
            ["900070000000", "nine hundred billion, seventy million naira only"],
        ];
    }

    /**
     * @dataProvider largeNumbersDataProvider
     */
    public function testLargeNumbers($largeNumber, $expectedMessage)
    {
        $this->assertEquals(
            $expectedMessage,
            $this->converter->convert($largeNumber)
        );
    }

    public function numberWithZeroPrefixDataProvider()
    {
        return [
            ["0000000", ""],
            ["050003", "fifty thousand, three naira only"],
            ["050303", "fifty thousand, three hundred and three naira only"],
            ["005475923455", "five billion, four hundred and seventy-five million, nine hundred and twenty-three thousand, four hundred and fifty-five naira only"],
        ];
    }

    /**
     * @dataProvider numberWithZeroPrefixDataProvider
     */
    public function testNumberWithZeroPrefix($numberWithZeroPrefix, $expectedMessage)
    {
        $this->assertEquals(
            $expectedMessage,
            $this->converter->convert($numberWithZeroPrefix)
        );
    }

    public function decimalNumberDataProvider()
    {
        return [
            ["23.0", "twenty-three naira only"],
            ["345003.09", "three hundred and forty-five thousand, three naira, nine kobo only"],
            ["233464773.457", "two hundred and thirty-three million, four hundred and sixty-four thousand, seven hundred and seventy-three naira, forty-six kobo only"],
        ];
    }

    /**
     * @dataProvider decimalNumberDataProvider
     */
    public function testDecimalNumber($decimalNumber, $expectedMessage)
    {
        $this->assertEquals(
            $expectedMessage,
            $this->converter->convert($decimalNumber)
        );
    }
}
