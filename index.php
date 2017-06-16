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
      
      //or
      
      $money = 748247284782;

      //naira
      $converter = new MoneyToWordsConverter($money, "naira");
      echo ($converter->Convert());

      echo "<br>";

      //dollar
      $converter->ChangeCurrency("dollar");
      echo ($converter->Convert());
    ?>

  </body>
</html>
