<?php

/**
 * Autoload files using Composer autoload
 */

use PHPUnit\Framework\TestCase;
use TNkemdilim\MoneyToWords\Converter;
use TNkemdilim\MoneyToWords\Languages as Language;

class ArabicConversionTest extends TestCase
{
    protected $converter;

    protected function setUp(): void
    {
        $this->converter = new Converter('ريال', 'هللة', Language::ARABIC);
    }

    public function wholeNumberDataProvider()
    {
        return [
            ["34", "thirty-four naira only"],
            ["345", "three hundred and forty-five naira only"],
            // ["345003", "three hundred and forty-five thousand, three naira only"],
            // ["23455", "twenty-three thousand, four hundred and fifty-five naira only"],
            // ["475923455", "four hundred and seventy-five million, nine hundred and twenty-three thousand, four hundred and fifty-five naira only"],
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
}
