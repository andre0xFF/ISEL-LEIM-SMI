<!DOCTYPE html>
<?php
require_once( "../Lib/lib.php" );
require_once ("../06-Forms/regex.php");

$flags[] = FILTER_NULL_ON_FAILURE;


?>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>Authentication Using PHP</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <link rel="stylesheet" type="text/css" href="../Styles/GlobalStyle.css">
    </head>

    <body>

    <form action="processFormLogin.php" method="POST">
        <table>
            <tr>
                <td>User Name</td>
                <td><input type="text" name="username" placeholder="Type your name" required pattern="<?=htmlspecialchars(ALIAS_REGEX, ENT_QUOTES)?>"></td>
            </tr>
            <tr>
                <td>Password</td>
                <td><input type="password" name="password" placeholder="Type your password" required pattern="<?=htmlspecialchars(PASS_REGEX, ENT_QUOTES)?>"></td>
            </tr>
        </table>

        <input type="submit" value="Login"> <input type="reset" value="Clear">
    </form>
    </body>
</html>
