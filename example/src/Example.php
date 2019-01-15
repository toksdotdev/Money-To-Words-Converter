<?php

require_once __DIR__ . '/../vendor/autoload.php';

use TNkemdilim\MoneyToWords\Converter;

$converter = new Converter("naira", "kobo");

echo ($converter->convert(374));
echo ($converter->convert(23.45));
echo ($converter->convert(748247284782));
echo ($converter->convert(748247284782.34));
echo ($converter->convert('34'));
echo ($converter->convert('2345.34'));
echo ($converter->convert('3453345'));
