<!DOCTYPE html>
<?php
require_once( "../Lib/lib.php" );

$name = webAppName();
?>

<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>

        <title>Accessing Web Services using PHP</title>

        <link rel="stylesheet" type="text/css" href="../Styles/GlobalStyle.css">
    </head>

    <body>
        <span class='mainPageEntry'><a target="content" href="<?php echo $name; ?>main.php">Main</a></span><br>
        <span class='mainPageEntry'><a target="content" href="<?php echo $name; ?>clientSoap.php">PHP SOAP Client</a></span><br>
        <span class='mainPageEntry'><a target="content" href="<?php echo $name; ?>links.php">Useful links</a></span><br>
        <br>
        <span class='mainPageEntry'><a target="_top" href="../">Back to Example Pages</a></span>
    </body>
</html>