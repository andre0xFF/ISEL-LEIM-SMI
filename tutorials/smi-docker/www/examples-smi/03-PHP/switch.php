<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <title>PHP - Switch statement - Numerical</title>
  </head>
  <body>
    <?php
      function f1($i) {
        switch ($i) {
          case 0:
            echo "<p>\$i equals 0";
            break;
          case 1:
            echo "<p>\$i equals 1";
            break;
          case 2:
            echo "<p>\$i equals 2";
            break;
          default:
            echo "<p>\$i is greater then 2";
        }
      }
      f1(0);
      f1(1);
      f1(2);
      f1(3);
    ?>
      </body>
</html>