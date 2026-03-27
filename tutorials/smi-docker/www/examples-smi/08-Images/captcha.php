<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>Image Processing</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <link rel="stylesheet" type="text/css" href="../Styles/GlobalStyle.css">
    </head>

  <body>
<?php
    include_once( "configDebug.php" );

    if ($debug == true) {
        $value = "value=\"" . $captchaValue . "\"";
        echo "<p>Debug is active</p>";
    } else {
        $value = "value=\"\"";
    }
?>

        <form method="post" action="captchaProcess.php">
            <img src="captchaImage.php"/><br>

            <label for="captcha">Digit Code</label><br>

            <input type="text" name="captcha" id="captcha" <?php echo $value; ?>><br>

            <input type="submit" value="Send"> <input type="reset" value="Clear">
        </form>
    </body>
</html>
