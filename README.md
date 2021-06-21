# Money To Words Converter

[![Packagist](https://img.shields.io/packagist/dt/tnkemdilim/money-to-words-converter.svg)](https://packagist.org/packages/tnkemdilim/money-to-words-converter)
[![Build Status](https://travis-ci.org/TNkemdilim/Money-To-Words-Converter.svg?branch=master)](https://travis-ci.org/TNkemdilim/Money-To-Words-Converter)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/tnkemdilim/money-to-words-converter.svg)](https://packagist.org/packages/tnkemdilim/money-to-words-converter)
[![Packagist](https://img.shields.io/packagist/v/tnkemdilim/money-to-words-converter.svg)](https://packagist.org/packages/tnkemdilim/money-to-words-converter)

A php library that converts any money value in digit in any language or numeric system to its words in any language

## Caveat

Currently, this library relies on [stichoza/google-translate-php](https://github.com/Stichoza/google-translate-php#known-limitations) which could result in periodic `400 Bad Request` as highlighted [here](https://github.com/Stichoza/google-translate-php#known-limitations) and [here](https://github.com/tnkemdilim/Money-To-Words-Converter/issues/21).

If you care about reliability, kindly checkout a managed API service I run: [Tuforty](https://tuforty.com).

## Installation

- Install this package via [Composer](https://getcomposer.org).

```php
composer require tnkemdilim/money-to-words-converter
```

- Or edit your project's `composer.json` to require `tnkemdilim/money-to-words-converter` and then run `composer update`.

```php
"require": {
    "tnkemdilim/money-to-words-converter": "^2"
}
```

## Example

For working example, checkout the [Example folder](./example).

## Usage

> Note: You should have composer's autoloader included `require 'vendor/autoload.php'`

Always include **Converter** namespace to your php file

### Basic usage

```php
use TNkemdilim\MoneyToWords\Converter;

// Nigerian currency : naira & kobo
$converter = new Converter("naira", "kobo");
echo ($converter->convert(374));
echo ($converter->convert(23.45));
echo ($converter->convert(748247284782));
echo ($converter->convert(748247284782.34));
echo ($converter->convert('34'));
echo ($converter->convert('2345.34'));
echo ($converter->convert('3453345'));
```

### Other Languages

To convert money value to other languages, you'll need to import the `Languages` namespace

```PHP
use TNkemdilim\MoneyToWords\Converter;
use TNkemdilim\MoneyToWords\Languages as Language;

$converter = new Converter("naira", "kobo", Language::FRENCH);

echo ($converter->convert(23.45));
echo ($converter->convert("748247284782"));
```

## Convertion From Other Numeric System

Conversion from other numeric systems are supported in-built, and by default needs no extra configuration to convert into words.

> Read more about [Numeric systems](https://en.wikipedia.org/wiki/List_of_numeral_systems).

```php
// Chinese numeric system
$money = "八百七十二万七千八百二十四";

// Example 1
$converter = new Converter("yen", "sen");
echo ($converter->convert($money));

// Example 2: but convert money value to french
$frenchConverter = new Converter("yen", "sen", Language::FRENCH);
echo ($frenchConverter->convert("八百七十二万七千八百二十四"));
```

## Change Currency

To change the currency of the money to convert

```php
//  Dollars & Cents
$converter->setCurrency("dollar", "cents");
echo ($converter->convert(234.34)); // two hundred and thirty-four dollars, thirty-four cents only.

// Pounds & Pence
$converter->setCurrency("pounds", "pence");
echo ($converter->convert('23.3')); // twenty three pounds, 3 pence only.
```

## Change Language Translation

Language for translation can be easily changed as follows. All available languages can be accessed via the `TNkemdilim\MoneyToWords\Languages` class.

See all available in [Languages](./src/Languages.php).

```PHP
use TNkemdilim\MoneyToWords\Languages as Language;

$converter->setLanguage(Language::LATIN);
$converter->setLanguage(Language::SWAHILI);
$converter->setLanguage(Language::GREEK);
```

## Supported Languages

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

## Contribution

1. Fork it!
2. Create your feature branch: `git checkout -b feature-name`
3. Commit your changes: `git commit -am 'Some commit message'`
4. Push to the branch: `git push origin feature-name`
5. Submit a pull request 😉😉

## License

MIT © Tochukwu Nkemdilim
