<!DOCTYPE html>
<?php
    require_once( "../Lib/lib.php" );
?>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>Login form - Forms App</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
         
        <link rel="stylesheet" type="text/css" href="../Styles/GlobalStyle.css">

        <script type="text/javascript" src="varsLogin.php"></script>
        <script type="text/javascript" src="scripts/forms.js?v=20260328"></script>
    </head>

    <body>
        <div>
            <div>
                <h1 align="center">Processing HTML forms with PHP</h1>
            </div>
            <div>
                <img src="images/LogoBig.png" alt="Logo" class="bigScreen"/>
                <img src="images/LogoSmall.png" alt="Logo" class="smallScreen"/>
            </div>
            <div class="bigScreen">
                <h2 align="center">Your Browser is <?php echo getBrowser();?></h2>
            </div>
        </div>

        <br>

        <form 
            action="processFormLogin.php"
            onsubmit="return FormLoginValidator(this)"
            name="FormLogin"
            method="post" >
            <table>
                <tr>
                    <td>Name:</td>
                    <td><input type="text" id="nameID" name="name" placeholder="Type your name" required></td>
                </tr>
                <tr>
                    <td>E-mail:</td>
                    <td><input type="text" id="emailID" name="email" placeholder="Type your e-mail" required></td>
                </tr>
                <tr>
                    <td><input type="submit" value="Send"></td>
                    <td><input type="reset" value="Reset"></td>
                </tr>        
            </table>
        </form>

        <div class="bigScreen">
<?php include_once( "notes.inc" ); ?>
        </div>
        
        <hr>
        <p><a href="./index.php">Back</a></p>

    </body>
</html>
