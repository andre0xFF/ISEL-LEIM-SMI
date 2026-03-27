<?php
    $scriptFile = $_GET['file'];

    $scriptFileName = "systemScripts/" . $scriptFile;

    $fd = fopen($scriptFileName, "rb" );

    header( "Content-type: text/plain" );
    header( "Content-Length: " . filesize( $scriptFileName ) );

    fpassthru( $fd );
    fclose( $fd );
?>
