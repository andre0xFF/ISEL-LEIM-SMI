<!DOCTYPE html>
<?php
ini_set('display_errors', 'On');

error_reporting(E_ALL);

require_once( "../Lib/lib.php" );

$name = webAppName();
?>

<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>

        <title>Accessing Web Services using PHP</title>

        <link REL="stylesheet" TYPE="text/css" href="../Styles/GlobalStyle.css">
    </head>

    <body>
        <span class='mainPageEntry'><a target="content" href="<?php echo $name; ?>clientBookStore.php">PHP Book Store Client</a></span><br>
        <br>
        <span class='mainPageEntry'><a target="_top" href="../">Back to Example Pages</a></span>
    </body>
</html>