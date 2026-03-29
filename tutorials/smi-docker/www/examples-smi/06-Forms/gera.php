<?php
  require_once("varsProfile.php");

?>

var xx = "<?php echo $x;?>";

function xpto() {
  alert( xx + "teste");	// alert( "<?php echo $x;?>" );
}

function f2() {
  alert( "xxxx" );
}