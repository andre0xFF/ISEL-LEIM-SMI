<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <title>PHP - Static Variables</title>
  </head>
  <body>
    <?php
      function f1() {
      	static $a = 0;	// Local Scope
 
      	echo "      <p> \$a inside function \"f1()\": " . ++$a;
      	//$a++;
      }            
      f1();
      f1();
      f1();
      f1();
      f1();
      
      f1();
    ?>
  </body>
</html>
