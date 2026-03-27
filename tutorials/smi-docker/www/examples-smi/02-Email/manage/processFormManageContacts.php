<?php
    $operation = $_POST[ 'operation' ];

    header( "Location: " . "formManageContacts" . $operation . ".php" );
?>
