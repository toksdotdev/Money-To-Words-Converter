# Money To Words Converter
A php library that helps onvetr any money value in digit to its corresponging word

# Installation
* Execute ``` composer require christs_dev/money-to-words-converter ``` to install
* Paste the code below into the php file where you want to use money converter

```php

<?php
  require_once __DIR__ . '/vendor/autoload.php';

  use MoneyToWords\MoneyToWordsConverter;
?>

```


# Usage
```php

$money = 748247284782;

//naira
$converter = new MoneyToWordsConverter($money, "naira");
echo ($converter->Convert());

```


# Change Currency
```php

//dollar
$converter->ChangeCurrency("dollar");
echo ($converter->Convert());

//pounds
$converter->ChangeCurrency("pounds");
echo ($converter->Convert());

```
