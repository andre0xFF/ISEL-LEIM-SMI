<?php
    ini_set('display_errors', 'On');

    error_reporting(E_ALL);

    include_once( "ensureAuth.php" );
    include_once( "header.php" );
?>


        <p>Contents of page 1</p>
<?php
    @session_start();
    
    include( "./files/xpto.php" );
    echo "\t\t$myVar\n\t\t<br>\n";

    include_once( "session.inc" );
    include_once( "footer.php" );
?>