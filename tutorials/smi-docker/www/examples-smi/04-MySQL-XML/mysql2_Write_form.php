<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>MySQL - Example 2 - Write</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <link rel="stylesheet" type="text/css" href="../Styles/GlobalStyle.css">
    </head>

    <body>
        <h1 align="center">MySQL - Example 2 - Write - Form</h1>

        <form action="mysql2_Write_process.php" method="post" >

            <p>Display Name: <input type="text" name="name" value="name"></p>
            <p>Email address: <input type="text" name="email" value="e-mail"></p>

            <p><input type="submit" value="Send">  <input type="reset" value="Reset"></p>
        </form>

        <br><a href="javascript: history.go(-1)">Back</a>
    </body>
</html>