<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>PHP - Arrays</title>
    </head>
    <body>
        <pre>
<?php
            ini_set('display_errors', 'Off');

            $x;
            if ( !isset( $x ) ) {
                echo '$x' . " não está definida com isset\n<br>";
            }
            else {
                echo '$x' . " está definida com isset\n<br>";
            }

            if ( $x==NULL ) {
                echo '$x' . " não está definida com null\n<br>";
            }
            else {
                echo '$x' . " está definida com null\n<br>";
            }

            $x=4;
            if ( isset( $x) ) {
                echo '$x' . " está definida com isset\n<br>";
            }
            else {
                echo '$x' . " não está definida com isset\n<br>";
            }

            if ( $x!=NULL ) {
                echo '$x' . " está definida com null\n<br>";
            }
            else {
                echo '$x' . " não está definida com null\n<br>";
            }

            $x=null;
            if ( isset( $x) ) {
                echo '$x' . " está definida com isset\n<br>";
            }
            else {
                echo '$x' . " não está definida com isset\n<br>";
            }

            if ( $x!=NULL ) {
                echo '$x' . " está definida com null\n<br>";
            }
            else {
                echo '$x' . " não está definida com null\n<br>";
            }

            $x=4;
            if ( isset( $x) ) {
                echo '$x' . " está definida com isset\n<br>";
            }
            else {
                echo '$x' . " não está definida com isset\n<br>";
            }

            if ( $x!=NULL ) {
                echo '$x' . " está definida com null\n<br>";
            }
            else {
                echo '$x' . " está definida com null\n<br>";
            }

            unset($x);
            if ( isset( $x) ) {
                echo '$x' . " está definida\n<br>";
            }
            else {
                echo '$x' . " não está definida\n<br>";
            }

            if ( $x!=NULL ) {
                echo '$x' . " está definida\n<br>";
            }
            else {
                echo '$x' . " não está definida\n<br>";
            }            
?>
        </pre>
        <a href="../index.php"></a>
    </body>
</html>