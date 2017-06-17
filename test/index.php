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
      
      $money = 748247284782;

      //naira
      $converter = new MoneyToWordsConverter($money, "naira");
      echo ($converter->Convert());

      echo "<br>";

      //dollar
      $converter->ChangeCurrency("dollars");
      echo ($converter->Convert());
    ?>

  </body>
</html>
