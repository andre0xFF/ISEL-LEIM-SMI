<!DOCTYPE html>
<?php
    require_once( "../../Lib/lib.php" );
    require_once("../../06-Forms/regex.php");
    require_once("../../Lib/lib-mail-v2.php");



include_once("../../08-Images/configDebug.php");


   // $value = "value=\"" . $captchaValue . "\"";






$flags[] = FILTER_NULL_ON_FAILURE;

    $serverName = filter_input( INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING, $flags);

    $serverPortSSL = 443;
    $serverPort = 80;

    $name = webAppName();
?>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>Authentication Using PHP</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <link rel="stylesheet" type="text/css" href="../../Styles/GlobalStyle.css">
    </head>

    <body>
        <form action="processFormRegister.php" method="POST">
            <table>
                <tr>
                    <td>User Name</td>
                    <td><input type="text" name="username" placeholder="Type your name" required pattern="<?=htmlspecialchars(ALIAS_REGEX, ENT_QUOTES)?>"></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type="email" name="email" placeholder="Type a valid email" required></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="password" name="password" placeholder="Type your password" required pattern="<?=htmlspecialchars(PASS_REGEX, ENT_QUOTES)?>"></td>
                </tr>
                <tr>
                    <td>Captcha</td>
                    <td>
                        <img src="../../08-Images/captchaImage.php" alt="Captcha image"><br>
                        <label for="captcha">Digit Code</label><br>
                        <input type="text" name="captcha" id="captcha" required>
                    </td>
                </tr>
            </table>







            <input type="submit" value="Register"> <input type="reset" value="Clear">
        </form>
    </body>
</html>
