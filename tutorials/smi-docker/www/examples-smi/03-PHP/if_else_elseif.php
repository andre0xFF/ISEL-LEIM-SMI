<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <title>PHP - If / else / elseif statement</title>
  </head>
  <body>
    <?php
      function f($a, $b) {
      	echo "<p>f($a, $b)";
      
      	if ( $a < $b ) {
      	  echo "<p>\$a &lt; \$b";
        }
        elseif ( $a > $b ) {
      	  echo "<p>\$a &gt; \$b";
        }
        else {
      	  echo "<p>\$a = \$b";
        }
      }
      f(1,2);
      f(2,2);
      f(2,1);
    ?>
  </body>
</html>