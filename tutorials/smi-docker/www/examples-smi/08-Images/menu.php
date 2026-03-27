<!DOCTYPE html>
<html>
<?php
    require_once( "../Lib/lib.php" );

    $name = webAppName();
?>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>Image Processing</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <link rel="stylesheet" type="text/css" href="../Styles/GlobalStyle.css">
    </head>

    <body>
        <span class='mainPageEntry'><a target="content" href="<?php echo $name ?>main.php">Home</a></span><br>
        <span class='mainPageEntry'><a target="content" href="<?php echo $name ?>formUpload.php">Upload File</a></span><br>
        <span class='mainPageEntry'><a target="content" href="<?php echo $name ?>list.php">List Files</a></span><br>
        <span class='mainPageEntry'><a target="content" href="<?php echo $name ?>stats.php">Show Statistics</a></span><br>
        <span class='mainPageEntry'><a target="content" href="<?php echo $name ?>captcha.php">Generate captcha</a></span><br>
        <span class='mainPageEntry'><a target="content" href="<?php echo $name ?>links.php">Useful Links</a></span><br>
        <span class='mainPageEntry'><a target="content" href="<?php echo $name ?>static/jwplayer.php">JWPlayer6 Play Video Demo</a></span><br>
        <span class='mainPageEntry'><a target="content" href="<?php echo $name ?>static/html5.php">HTML 5 Play Video Demo</a></span><br>
        <br>
        <span class='mainPageEntry'><a target="_top" href="../">Back to Examples Pages</a>
    </body>
</html>
