<?php
  // Autoload files using Composer autoload
  require_once __DIR__ . '../../vendor/autoload.php';

  use MoneyToWords\MoneyToWordsConverter;
?>



<!DOCTYPE html>
<html>
  <head>
    <title>Money Converter</title>
  </head>

  <body>

    <?php
      
      /*
      * FOR API, YOU COULD USE THIS
      * $money = $_GET['money'];
      * 
      * [url]/index.php?money=4984894989834894
      * 
      * e.g. moneyconveter.com/test?money=4984894989834894
      */
      
      $money = "八百七十二万七千八百二十四";

      //naira
      $converter = new MoneyToWordsConverter($money, "naira", 'en');
      echo $converter->Convert();
      echo "<br>";

      //dollar
      $converter->ChangeCurrency("dollars");
      echo ($converter->Convert());
      echo "<br>";

      //set new currency value
      $converter->SetMoneyValue(28747847);

      //convert new currency value
      $converter->SetCurrency("dollars");
      echo ($converter->Convert());
    ?>

  </body>
</html>
