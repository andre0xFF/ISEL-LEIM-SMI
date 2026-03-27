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
        <title>Accessing REST Web Services using PHP</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <link REL="stylesheet" TYPE="text/css" href="../Styles/GlobalStyle.css">
    </head>

    <frameset rows="10%,*">

        <frame name="title" noresize scrolling="no" src="<?php echo $name ?>title.php">

            <frameset cols = "20%, *">
                <frame noresize name="option" src ="<?php echo $name ?>menu.php" />
                <frame name="content" src ="<?php echo $name ?>clientBookStore.php" />
            </frameset>
    </frameset>
</html>
