<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <title>PHP - Strings</title>
  </head>
  <body>
    <p></p>
    <?php
    
      $s1 = "O'la";
      $s2 = 'O"la';
      
      $s3 = "O\"la";
      $s4 = 'O\'la';
      
      $s5 = "5s";
      $s6 = "7";
      $s7 = $s5 + $s6;
      $s8 = $s5 . $s6;
      
      echo "caso 0\<br>";
      echo $s7 . "\n<br>";
      echo $s8 . "\n<br>";
      
      echo "caso 1\<br>";
      $var1 = "5";
      
      $var2 = "The value of the variable is: '$var1'";
      
      echo "$var2\n<br>";

      echo '$var2\n<br>';

      echo $var2 . "\n<br>"; // <=> echo "$var2\n<br>";
	  
    ?>
    
    <p></p>
    <?php
      echo "caso 2\n<br>";
      $var1 = 5;
	  
      $var2 = 'The value of the variable is: "$var1"';
      
      echo "$var2\n<br>";
      echo '$var2';
    ?>
    
    <p></p>
    <?php
      echo "caso 3\n<br>";
      $var1 = 5;
      $var2 = 'The value of the variable is: $var1';
      echo $var2;
      echo '$var2';
    ?>
        
    <p></p>
    <?php
      echo "caso 4\n<br>";
      $hello = "He'llo";
      $world = 'wo"rld';
      echo $hello . " " . $world;
    ?>
        
    <p>
      
    <?php
    /*
      $i1 = 68;
      $i2 = 5;
      $i3 = 0b10100101;
      
      echo '$i1 -> ' . $i1 . "\n<br>";
      echo '$i2 -> ' . $i2 . "\n<br>";
      echo '$i3 -> ' . $i3 . "\n<br>";
      */
    ?>
      
    
    <p>
    <?php
      $s1 = "5";
      $s2 = "6";
      
      echo '$s1 . $s2 = ' . $s1 . $s2;
      echo "\n<br>";
      
      $aux = '$s1 + $s2 = ' . ($s1 + $s2);
      echo $aux;
      echo "\n<br>";
    ?>
	
	<?php
	  echo "ola com aspas\n<br>";
	  echo 'ola com plicas\n<br>';
	?>
  </body>
</html>
