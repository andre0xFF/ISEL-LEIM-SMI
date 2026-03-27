<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <title>Hello World</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    
    <link rel="stylesheet" type="text/css" href="../Styles/GlobalStyle.css">
  </head>
  <body>    
<?php

  foreach($_SERVER as $key=>$value) {
    echo "\$_SERVER[ $key ] = $value \n<br>";
  }
  
  echo "\n<br>";
  
  echo "<pre>";
  print_r( $_SERVER );
  echo "</pre>";
  echo "\n<br>";
 
  if ( isset( $_SERVER[ 'REMOTE_ADDR' ] ) ) {
    $browserAddress = $_SERVER[ 'REMOTE_ADDR' ];
  }
  else {
    $browserAddress = "N.A.";
  }
  
  if ( isset( $_SERVER[ 'REMOTE_HOST' ] ) ) {
    $browserHost = $_SERVER[ 'REMOTE_HOST' ];
  }
  else {
    $browserHost = "N.A.";
  }
  
  if ( isset( $_SERVER[ 'SERVER_NAME' ] ) ) {
    $serverName = $_SERVER[ 'SERVER_NAME' ];
  }
  else {
    $serverName = "N.A.";
  }

  echo "<p>Hello. Yor are viewing this page from $browserHost ($browserAddress) generated @ $serverName</p>";
  
  echo "<p>To get the fully qualified name for the Apache Web server modify the following tags:</p>\n";
  
  echo "<code>ServerName MyServerName</code> in \"httpd.conf\" file +/- line 219\n<br>";
  echo "<code>UseCanonicalName On</code> in \"extra/httpd-default\" file +/- line 38\n<br>";
?>

  <br>
  <hr>
  <a href="../index.php">Back to Examples Pages</a>

  </body>
</html>