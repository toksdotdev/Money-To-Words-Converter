<!-- INCLUDE MONEY TO WORD CONVERTER TO FILE -->
<?php include 'moneytowordsconverter.php';  ?>

<!DOCTYPE html>
<html>
  <head>
    <title>Money Converter</title>
  </head>

  <body>
    
    <!-- implemantation -->
    <?php

      //FOR API, YOU COULD USE THIS
      $money = $_GET['money'];

      $converter = new MoneyToWordsConverter($money, "naira");

      echo ($converter->Convert()); 
    ?>

  </body>
</html>
