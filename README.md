# Money To Words Converter
A php library that converts any money value from digits to its corresponging word

# Installation
* Install this package via [Composer](https://getcomposer.org).
```php
composer require christs_dev/money-to-words-converter 
```

* Or edit your project's ```composer.json``` to require ```christs_dev/money-to-words-converter``` and then run ```composer update ```.
```php
"require": {
    "christs_dev/money-to-words-converter": "*"
}
```



# Usage
**Basic usage**
> Note: You should have composer's autoloader included ``` require 'vendor/autoload.php' ```

<br>

* Include **MoneyToWordsCoverter** namespace to your php file

```php

<?php

  use MoneyToWords\MoneyToWordsConverter;

?>

```
<br>

* Instantiate the **MoneyToWordsConverter** object

```php

$money = 748247284782;

//naira
$converter = new MoneyToWordsConverter($money, "naira");
echo ($converter->Convert());

```


# Change Currency
To change the currency of the money to convert
```php

//dollar
$converter->ChangeCurrency("dollar");
echo ($converter->Convert());

//pounds
$converter->ChangeCurrency("pounds");
echo ($converter->Convert());

```
