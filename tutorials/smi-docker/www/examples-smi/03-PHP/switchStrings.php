<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <title>PHP - Switch statement - Strings </title>
  </head>
  <body>
    <?php
      function f1($food) {
        switch ($food) {
          case "apple":
            echo "<p>\$food is apple";
            break;
          case "cake":
            echo "<p>\$food is cake";
            break;
          case "pie":
            echo "<p>\$food is pie";
            break;
        }
      }
      f1("apple");
      f1("cake");
      f1("pie");
    ?>
      </body>
</html>