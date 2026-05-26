<?php
  header( "Content-Type: text/html; charset=utf-8" );
  
  include_once( "../Lib/lib.php" );
  
  $field = "Brágança";
  $r1 = $field;
    
  $r2 = convertToEntities($field );
  
  echo "$r1<br>\n";
  echo "$r2<br>\n";
?>