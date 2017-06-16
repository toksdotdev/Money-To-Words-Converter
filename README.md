# Money To Words Converter
A php library that helps onvetr any money value in digit to its corresponging word

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
