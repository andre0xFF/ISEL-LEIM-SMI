<html>
  <?php
    require_once( "../Lib/lib.php" );

  $name = webAppName();
  ?>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>Rich Site Summary - RSS - Using iFrames</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        
        <link rel="stylesheet" typr="text/css" href="../Styles/GlobalStyle.css">
        <link rel="stylesheet" type="text/css" href="styles/rss.css">
    </head>

    <body>
        <div 
            accesskey="" 
            id="containerDiv"
            style="height:99%;width:99%;background-color:lightgrey">

            <div 
                id="headerDiv" 
                style="height:15%;width:99.5%;background-color:lightgrey">

                <iframe
                    name="header"
                    width="100%" 
                    height="100%"
                    style="background-color: transparent"
                    src="<?php echo $name ?>title.php">
                </iframe>

            </div>

            <div 
                id="menuDiv" 
                style="height:77.5%;width:14%;float:left;background-color:lightgrey">

                <iframe 
                    name="menu"
                    width="100%" 
                    height="100%"
                    style="background-color: transparent"
                    src="<?php echo $name ?>menu.php">
                </iframe>

            </div>

            <div 
                id="contentDiv"
                style="height:77.5%;width:84%;float:right;background-color:lightgrey">

                <iframe 
                    name="content"
                    width="100%" 
                    height="100%"
                    style="background-color: transparent"
                    src="<?php echo $name ?>formAddNew.php">
                </iframe>

            </div>

        </div>

    </body>

</html>