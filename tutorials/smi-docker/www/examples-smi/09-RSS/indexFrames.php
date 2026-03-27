<!DOCTYPE html>
<html>
<?php
    require_once( "../Lib/lib.php" );

    $name = webAppName();
?>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>Rich Site Summary - RSS - Using Frames</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        
        <link rel="stylesheet" typr="text/css" href="../Styles/GlobalStyle.css">
        <link rel="stylesheet" type="text/css" href="styles/rss.css">
    </head>

    <frameset rows="10%,*">
        <frame name="title" noresize scrolling="no" src="<?php echo $name ?>title.php">

        <frameset cols = "20%,*">
            <frame noresize name="option" src ="<?php echo $name ?>menu.php" />
            <frame name="content" src ="<?php echo $name ?>formAddNew.php" />
        </frameset>
    </frameset>
</html>
