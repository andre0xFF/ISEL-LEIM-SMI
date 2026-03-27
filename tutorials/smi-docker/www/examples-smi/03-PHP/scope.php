<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <title>PHP - Variable Scope</title>
  </head>
  <body>
    <?php
      $a = 1;         // Global scope
      
      function f1() {
      	$a = 4;       // Local Scope
      	echo "      <p> \$a inside function \"f1()\": $a";
      }

      function f2() {
        $a = 5;       // Local Scope
        echo "      <p> \$a inside function \"f2()-1\": $a";
      	
        global $a;    // Global Scope
        echo "      <p> \$a inside function \"f2()-2\": $a";
        $a = $a;
        
        echo "      <p> \$a inside function \"f2()-3\": $a";
        $a = 6;
      	echo "      <p> \$a inside function \"f2()-4\": $a";
      }

      function f3() {
      	$a = $GLOBALS[ "a" ];   // Global Scope
        
        echo "      <p> \$a inside function \"f3()-1\": $a";
        $a = 8;                 // Local Scope

        echo "      <p> \$a inside function \"f3()-2\": $a";
      }
      
      function f4() {
        $a = 10;
        
      	$GLOBALS[ "a" ] = $a;
        
        echo "      <p> \$a inside function \"f4()\": $a";
      }
            
      f1();
      echo "      <p> \$a after the invocation of function \"f1()\": $a\n";
      f2();
      echo "      <p> \$a after the invocation of function \"f2()\": $a\n";
      f3();
      echo "      <p> \$a after the invocation of function \"f3()\": $a\n";
      f4();
      echo "      <p> \$a after the invocation of function \"f4()\": $a\n";
    ?>
  </body>
</html>
