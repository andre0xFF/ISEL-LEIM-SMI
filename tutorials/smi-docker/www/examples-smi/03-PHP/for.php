<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <title>PHP - For statement</title>
  </head>
  <body>
    <?php
      $i;
      for($idx=1; $idx<10; $idx++) {
      	$i = $idx;
      	
      	if ( $idx % 2 ) {
      		continue;
      	}
      	else {
      		echo "<p> $idx";
      	}
      	
      	if ( $idx == 6 ) {
      		break;
      	} 
      }
      echo "<p> \$i: $i";
    ?>
  </body>
</html>