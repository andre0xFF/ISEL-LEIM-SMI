<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <title>PHP - Do ... while statement</title>
  </head>
  <body>
    <?php
      $idx = 10 ;
      
      do {
      	print $idx--;
      	print ',';
      } while ( $idx>0 )
    ?>
  </body>
</html>