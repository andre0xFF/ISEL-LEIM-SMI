<?php
  require_once( "vars.php" );
?>

var xx = "<?php echo $x;?>";

function xpto() {
  alert( xx );	// alert( "<?php echo $x;?>" );
}

function f2() {
  alert( "xxxx" );
}