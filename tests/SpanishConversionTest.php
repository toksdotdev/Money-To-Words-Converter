<?php

/**
 * Autoload files using Composer autoload
 */

use PHPUnit\Framework\TestCase;
use TNkemdilim\MoneyToWords\Converter;
use TNkemdilim\MoneyToWords\Languages as Language;

class SpanishConversionTest extends TestCase
{
    protected $converter;

    protected function setUp(): void
    {
        $this->converter = new Converter("naira", "kobo", Language::SPANISH);
    }

    public function wholeNumberDataProvider()
    {
        return [
            ["345", "tres cientos cuarenta y cinco naira solamente"],
            ["34", "treinta y cuatro naira solamente"],
            ["23455", "veintitrés mil cuatrocientos cincuenta y cinco naira solamente"],
            ["345003", "trescientos cuarenta y cinco mil tres naira solamente"],
            ["475923455", "cuatrocientos setenta y cinco millones novecientos veintitrés mil cuatrocientos cincuenta y cinco naira solamente"],
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
            ["50000000", "cincuenta millones naira solamente"],
            ["900000000000", "novecientos mil millones naira solamente"], #"novecientos mil millones naira solamente"
            ["900070000000", "novecientos mil setenta millones naira solamente"],
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
            ["050003", "cincuenta mil tres naira solamente"],
            ["050303", "cincuenta mil trescientos tres naira solamente"],
            ["005475923455", "cinco mil cuatrocientos setenta y cinco millones novecientos veintitrés mil cuatrocientos cincuenta y cinco naira solamente"],
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
            ["23.0", "Veintitres naira solamente"],
            ["345003.09", "trescientos cuarenta y cinco mil tres naira, nueve kobo solamente"],
            ["233464773.457", "doscientos treinta y tres millones cuatrocientos sesenta y cuatro mil setecientos setenta y tres naira, cuarenta y seis kobo solamente"],
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
