<?php
   require_once( "regex.php" );
   header('Content-Type: application/javascript; charset=utf-8');
?>
window.formPatterns = {
alias: <?php echo json_encode(ALIAS_REGEX)?>,
password: <?php echo json_encode(PASS_REGEX)?>
};
