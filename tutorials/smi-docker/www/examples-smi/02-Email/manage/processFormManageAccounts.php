<?php
    $operation = $_POST[ 'operation' ];

    header( "Location: " . "formManageAccounts" . $operation . ".php" );
?>
