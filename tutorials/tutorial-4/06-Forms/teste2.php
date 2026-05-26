<?php
header( "Content-Type: text/html; charset=utf-8" );

require_once ( "../Lib/lib.php" );

convertToEntities( "ola" );

$dim = count( $GLOBALS[ "find" ] );

echo "<table border=\"1\">\n";
for ($idx = 0; $idx < $dim; $idx++) {
  echo "  <tr>";
  echo "    <td>\$find[ $idx ] = " . $GLOBALS[ "find" ][$idx] . "</td>";
  echo "    <td>\$replace[ $idx ] = " . $GLOBALS[ "replace" ][$idx] . "</td>";
  echo "  </tr>\n";
}
echo "</table>\n";
?>