<?php
/**
 * Autoload files using Composer autoload
 */
use PHPUnit\Framework\TestCase;
use TNkemdilim\MoneyToWords\Converter;
use TNkemdilim\MoneyToWords\Languages as Language;
class ThaiConversionTest extends TestCase
{
    protected $converter;
    protected function setUp(): void
    {
        $this->converter = new Converter("naira", "kobo", Language::THAI);
    }
    public function testWholeNumber()
    {
        $this->assertEquals(
            $this->converter->convert("345"),
            "สามร้อยสี่สิบห้า naira"
        );
        $this->assertEquals(
            $this->converter->convert("34"),
            "สามสิบสี่ naira"
        );
        $this->assertEquals(
            $this->converter->convert("23455"),
            "สองหมื่นสามพันสี่ร้อยห้าสิบห้า naira"
        );
        $this->assertEquals(
            $this->converter->convert("345003"),
            "สามแสนสี่หมื่นห้าพันสาม naira"
        );
        $this->assertEquals(
            $this->converter->convert("475923455"),
            "สี่ร้อยเจ็ดสิบห้าล้าน เก้าแสนสองหมื่นสามพันสี่ร้อยห้าสิบห้า naira"
        );
    }
    public function testLargeNumbers()
    {
        $this->assertEquals(
            $this->converter->convert("50000000"),
            "ห้าสิบล้าน naira"
        );
        $this->assertEquals(
            $this->converter->convert("900000000000"),
            "เก้าแสนล้าน naira"
        );
        $this->assertEquals(
            $this->converter->convert("900070000000"),
            "เก้าแสนเจ็ดสิบล้าน naira"
        );
    }
    public function testNumberWithZeroPrefix()
    {
        $this->assertEquals($this->converter->convert("0000000"), "");
        $this->assertEquals(
            $this->converter->convert("050003"),
            "ห้าหมื่นสาม naira"
        );
        $this->assertEquals(
            $this->converter->convert("050303"),
            "ห้าหมื่นสามร้อยสาม naira"
        );
        $this->assertEquals(
            $this->converter->convert("005475923455"),
            "ห้าพันสี่ร้อยเจ็ดสิบห้าล้าน เก้าแสนสองหมื่นสามพันสี่ร้อยห้าสิบห้า naira"
        );
    }
    public function testDecimalNumber()
    {
        $this->assertEquals(
            $this->converter->convert("23.0"),
            "ยี่สิบสาม naira"
        );
        $this->assertEquals(
            $this->converter->convert("345003.09"),
            "สามแสนสี่หมื่นห้าพันสาม naira เก้า kobo"
        );
        $this->assertEquals(
            $this->converter->convert("233464773.457"),
            "สองร้อยสามสิบสามล้าน สี่แสนหกหมื่นสี่พันเจ็ดร้อยเจ็ดสิบสาม naira สี่ร้อยห้าสิบเจ็ด kobo"
        );
    }
}
// $money = "八百七十二万七千八百二十四";
// echo ($this->converter->convert($money) . "\n");
