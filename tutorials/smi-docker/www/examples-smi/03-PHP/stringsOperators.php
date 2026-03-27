<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <title>PHP - String operators</title>
  </head>
  <body>
    <?php
      $a = "Hello ";
      $b = $a . "world!"; // $b has "Hello world!"
      echo "<p>$b";
      $a = "Hello ";
      $a .= "world!";     // $a has "Hello world!"
      echo "<p>$a";
    ?>
  </body>
</html>
