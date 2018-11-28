<?php

/**
 * Autoload files using Composer autoload
 */

use TNkemdilim\MoneyToWords\Converter;
use TNkemdilim\MoneyToWords\Languages as Language;
use TNkemdilim\MoneyToWords\Exception;
use PHPUnit\Framework\TestCase;

class EnglishConversionTest extends TestCase
{
    protected $converter;

    protected function setUp() : void
    {
        $this->converter = new Converter("naira", "kobo", Language::ENGLISH);
    }

    public function testWholeNumber()
    {
        $this->assertEquals(
            $this->converter->convert("345"),
            "three hundred and forty-five naira only"
        );
        $this->assertEquals(
            $this->converter->convert("34"),
            "thirty-four naira only"
        );
        $this->assertEquals(
            $this->converter->convert("23455"),
            "twenty-three thousand, four hundred and fifty-five naira only"
        );
        $this->assertEquals(
            $this->converter->convert("345003"),
            "three hundred and forty-five thousand, three naira only"
        );
        $this->assertEquals(
            $this->converter->convert("475923455"),
            "four hundred and seventy-five million, nine hundred and twenty-three thousand, four hundred and fifty-five naira only"
        );
    }

    public function testNumberWithZeroPrefix()
    {
        $this->assertEquals($this->converter->convert("0000000"), "");
        $this->assertEquals(
            $this->converter->convert("050003"),
            "fifty thousand, three naira only"
        );
        $this->assertEquals(
            $this->converter->convert("050303"),
            "fifty thousand, three hundred and three naira only"
        );
        $this->assertEquals(
            $this->converter->convert("005475923455"),
            "five billion, four hundred and seventy-five million, nine hundred and twenty-three thousand, four hundred and fifty-five naira only"
        );
    }

    public function testDecimalNumber()
    {
        $this->assertEquals(
            $this->converter->convert("23.0"),
            "twenty-three naira only"
        );
        $this->assertEquals(
            $this->converter->convert("345003.09"),
            "three hundred and forty-five thousand, three naira, nine kobo only"
        );
        $this->assertEquals(
            $this->converter->convert("233464773.457"),
            "two hundred and thirty-three million, four hundred and sixty-four thousand, seven hundred and seventy-three naira, four hundred and fifty-seven kobo only"
        );
    }
}

// $money = "八百七十二万七千八百二十四";

// echo ($this->converter->convert($money) . "\n");
?>