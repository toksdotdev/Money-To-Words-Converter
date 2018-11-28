# Money To Words Converter

[![Packagist](https://img.shields.io/packagist/dt/tnkemdilim/money-to-words-converter.svg)](https://packagist.org/packages/tnkemdilim/money-to-words-converter)
[![Build Status](https://travis-ci.org/TNkemdilim/Money-To-Words-Converter.svg?branch=master)](https://travis-ci.org/TNkemdilim/Money-To-Words-Converter)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/tnkemdilim/money-to-words-converter.svg)](https://packagist.org/packages/tnkemdilim/money-to-words-converter)
[![Packagist](https://img.shields.io/packagist/v/tnkemdilim/money-to-words-converter.svg)](https://packagist.org/packages/tnkemdilim/money-to-words-converter)

A php library that converts any money value in digit in any language or numeric system to its words in any language

# Installation

- Install this package via [Composer](https://getcomposer.org).

```php
composer require tnkemdilim/money-to-words-converter
```

- Or edit your project's `composer.json` to require `tnkemdilim/money-to-words-converter` and then run `composer update`.

```php
"require": {
    "tnkemdilim/money-to-words-converter": "*"
}
```

# Usage

**Basic usage**

> Note: You should have composer's autoloader included `require 'vendor/autoload.php'`

<br>

- Include **MoneyToWordsCoverter** namespace to your php file

```php
<?php

  use TNkemdilim\MoneyToWords\MoneyToWordsConverter;

?>
```

<br>

- Instantiate the **MoneyToWordsConverter** object

```php
//greek numeric system
$money = 748247284782;

//naira
$converter = new MoneyToWordsConverter($money, "naira");
echo ($converter->Convert());

```

<br>

# Example

```php
//chinese numeric system
$money = "八百七十二万七千八百二十四";

//converts money value to french sentence,  with yen as a currency
$converter = new MoneyToWordsConverter($money, "yens", "fr");
echo ($converter->Convert());

```

> Find more numeric systems at [Numeric systems](https://en.wikipedia.org/wiki/List_of_numeral_systems)

<br>

# Set Converted Money Language

To set the language money should be translated into

```php
$converter = new MoneyToWordsConverter($money, "yens", "fr"); //french
$converter = new MoneyToWordsConverter($money, "yens"); //english is default
$converter = new MoneyToWordsConverter($money, "yens", "es"); //spanish
```

<br>

# Set a new language

```php
  $converter->SetLanguage('en');
  $converter->SetLanguage('fr');
  $converter->SetLanguage('zh-TW');
```

<br>

# Supported langauges

For more conversion types

<table>
  <tbody>
    <tr style="font-weight:bold">
      <td>Language Name</td>
      <td>Code</td>
      <td>Language Name</td>
      <td>Code</td>
      <td>Language Name</td>
      <td>Code</td>
      <td>Language Name</td>
      <td>Code</td>
    </tr>
    <tr>
      <td>Afrikaans</td>
      <td>af</td>
      <td>Irish</td>
      <td>ga</td>
      <td>Albanian</td>
      <td>sq</td>
      <td>Italian</td>
      <td>it</td>
    </tr>
    <tr>
      <td>Arabic</td>
      <td>ar</td>
      <td>Japanese</td>
      <td>ja</td>
      <td>Azerbaijani</td>
      <td>az</td>
      <td>Kannada</td>
      <td>kn</td>
    </tr>
    <tr>
      <td>Basque</td>
      <td>eu</td>
      <td>Korean</td>
      <td>ko</td>
      <td>Bengali</td>
      <td>bn</td>
      <td>Latin</td>
      <td>la</td>
    </tr>
    <tr>
      <td>Belarusian</td>
      <td>be</td>
      <td>Latvian</td>
      <td>lv</td>
      <td>Bulgarian</td>
      <td>bg</td>
      <td>Lithuanian</td>
      <td>lt</td>
    </tr>
    <tr>
      <td>Catalan</td>
      <td>ca</td>
      <td>Macedonian</td>
      <td>mk</td>
      <td>Chinese Simplified</td>
      <td>zh-CN</td>
      <td>Malay</td>
      <td>ms</td>
    </tr>
    <tr>
      <td>Chinese Traditional</td>
      <td>zh-TW</td>
      <td>Maltese</td>
      <td>mt</td>
      <td>Croatian</td>
      <td>hr</td>
      <td>Norwegian</td>
      <td>no</td>
    </tr>
      <tr>
      <td>Czech</td>
      <td>cs</td>
      <td>Persian</td>
      <td>fa</td>
      <td>Danish</td>
      <td>da</td>
      <td>Polish</td>
      <td>pl</td>
    </tr>
    <tr>
      <td>Dutch</td>
      <td>nl</td>
      <td>Portuguese</td>
      <td>pt</td>
      <td>English</td>
      <td>en</td>
      <td>Romanian</td>
      <td>ro</td>
    </tr>
    <tr>
      <td>Esperanto</td>
      <td>eo</td>
      <td>Russian</td>
      <td>ru</td>
      <td>Estonian</td>
      <td>et</td>
      <td>Serbian</td>
      <td>sr</td>
    </tr>
    <tr>
      <td>Filipino</td>
      <td>tl</td>
      <td>Slovak</td>
      <td>sk</td>
      <td>Finnish</td>
      <td>fi</td>
      <td>Slovenian</td>
      <td>sl</td>
    </tr>
    <tr>
      <td>French</td>
      <td>fr</td>
      <td>Spanish</td>
      <td>es</td>
      <td>Galician</td>
      <td>gl</td>
      <td>Swahili</td>
      <td>sw</td>
    </tr>
    <tr>
      <td>Georgian</td>
      <td>ka</td>
      <td>Swedish</td>
      <td>sv</td>
      <td>German</td>
      <td>de</td>
      <td>Tamil</td>
      <td>ta</td>
    </tr>
    <tr>
      <td>Greek</td>
      <td>el</td>
      <td>Telugu</td>
      <td>te</td>
      <td>Gujarati</td>
      <td>gu</td>
      <td>Thai</td>
      <td>th</td>
    </tr>
    <tr>
      <td>Haitian Creole</td>
      <td>ht</td>
      <td>Turkish</td>
      <td>tr</td>
      <td>Hebrew</td>
      <td>iw</td>
      <td>Ukrainian</td>
      <td>uk</td>
    </tr>
    <tr>
      <td>Hindi</td>
      <td>hi</td>
      <td>Urdu</td>
      <td>ur</td>
      <td>Hungarian</td>
      <td>hu</td>
      <td>Vietnamese</td>
      <td>vi</td>
    </tr>
    <tr>
      <td>Icelandic</td>
      <td>is</td>
      <td>Welsh</td>
      <td>cy</td>
      <td>Indonesian</td>
      <td>id</td>
      <td>Yiddish</td>
      <td>yi</td>
    </tr>
  </tbody>
</table>

<br>

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

<br>

# Set new currency value

To convert a new currency value

```php
//greek numeric system
$converter->SetMoneyValue(28747847);

//chinese numeric system
$converter->SetMoneyValue("八百七十二万七千八百二十四");
```
