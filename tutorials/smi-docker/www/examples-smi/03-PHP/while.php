<html>
  <head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <title>PHP - While statement</title>
  </head>
  <body>
    <?php
      $idx =1 ;
      
      while ( $idx<=10 ) {
      	print $idx++;
      	print ',';
      }
    ?>
    <p>
    <?php
      $idx = 1 ;
      
      while ( $idx<=10 ) {
      	print ++$idx;
      	print ',';
      }
    ?>
  </body>
</html>