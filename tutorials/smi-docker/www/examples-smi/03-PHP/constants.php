<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <title>PHP - Constants</title>
  </head>
  <body>
    <?php
      define( "Message1", "This is the error message number 1");
      define( "Message2", "This is the error message number 2");
      
      function showError( $file, $line, $message) {
      //function showError( $message) {
      	echo "<p>Something went wrong:";
      	echo "<p>File: $file";
      	echo "<p>Line: $line";
        //echo "<p>File: " . __FILE__;
      	//echo "<p>Line: " . __LINE__;
      	echo "<p>Message: $message\n<br>";
      }

      showError( __FILE__, __LINE__, Message1);

      showError( __FILE__, __LINE__, Message2);
      //showError( Message1);
      //showError( Message2);
    ?>
  </body>
</html>
