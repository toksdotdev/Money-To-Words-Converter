<?php include 'moneytowordsconverter.php';  ?>

<!DOCTYPE html>
<html>
  <head>
    <title>Money Converter</title>
  </head>

  <body>
    
    <!-- implemantation -->
    <?php 
      $converter = new MoneyToWordsConverter("54863467300000");

      echo ($converter->Convert());
    ?>

  </body>
</html>
