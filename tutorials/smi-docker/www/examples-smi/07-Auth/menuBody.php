<?php
    require_once( "../Lib/lib.php" );

    $name = webAppName();
?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../Styles/GlobalStyle.css">
        
        <link rel="stylesheet" type="text/css" href="./Styles/auth.css">
        
        <title>Menu body</title>
    </head>
    
    <body>

        Version 1 - HTTP Basic<br>
        <span class='mainPageEntry menuItemL1'><a target="content" href="<?php echo $name ?>Ver1/">Pages</a></span><br>
        <span class='mainPageEntry menuItemL1'><a target="content" href="<?php echo $name ?>Ver1/files/">Files</a></span><br>
        <br>

        Version 2 - HTTP Digest<br>
        <span class='mainPageEntry menuItemL1'><a target="content" href="<?php echo $name ?>Ver2/">Pages</a></span><br>
        <span class='mainPageEntry menuItemL1'><a target="content" href="<?php echo $name ?>Ver2/files/">Files</a></span><br>
        <br>

        Version 3 - PHP Sessions<br>
        <span class='mainPageEntry menuItemL1'><a target="_blank" href="<?php echo $name ?>Ver3/">Pages</a></span><br>
        <span class='mainPageEntry menuItemL1'><a target="content" href="<?php echo $name ?>Ver3/files/">Files</a></span><br>
        <br>

        <span class='mainPageEntry menuItemL1'><a target="content" href="<?php echo $name ?>links.php">Useful links</a></span><br>
        <br>
        <span class='mainPageEntry menuItemL1'><a target="_top" href="./">Back to Authentication Examples</a></span>

</body>