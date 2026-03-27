<!DOCTYPE html>
<?php
    require_once( "../Lib/lib.php" );

    $name = webAppName();
?>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>User Authentication using PHP</title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <link rel="stylesheet" type="text/css" href="../Styles/GlobalStyle.css">
        
        <link rel="stylesheet" type="text/css" href="./Styles/auth.css">
    </head>

    <body>

        <div 
            accesskey="" 
            id="container" 
            class="divPlaceHolderMain" >

            <div 
                id="header" 
                class="divPlaceHolderHeader divPlaceHolder">
                <iframe
                    style="border: 0px none;"
                    width="100%" 
                    height="100%" 
                    src="<?php echo $name ?>titleBody.php">
                </iframe>
            </div>

            <div 
                id="menu" 
                class="divPlaceHolderMenu divPlaceHolder">

                <iframe 
                    style="border: 0px none;"
                    width="100%" 
                    height="100%" 
                    src="<?php echo $name ?>menuBody.php">
                </iframe>
            </div>

            <div 
                id="content"
                class="divPlaceHolderContents divPlaceHolder">

                <iframe
                    style="border: 0px none;"
                    name="content"
                    width="100%" 
                    height="100%" 
                    src="<?php echo $name ?>links.php">
                </iframe>

            </div>

       </div>

    </body>

</html>