<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>MySQL - Example 1 - Read (Table)</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <link rel="stylesheet" type="text/css" href="../Styles/GlobalStyle.css">

        <link rel="stylesheet" type="text/css" href="../Styles/TableUsingDivs.css">
    </head>

    <body>
        <h1 align="center">MySQL - Example 1 - Read - Display using tag <code>table</code> </h1>
        <?php
        ini_set('display_errors', 'On');

        error_reporting(E_ALL);

        $host = "localhost";
        $port = 3306;
        $credentials = $host . ":" . $port;
        $userName = "smi";
        $password = "segredo";

        $dataBaseName = "smi";

        $linkIdentifier = mysqli_connect(
                $host,
                $userName,
                $password,
                $dataBaseName,
                $port);
    
        mysqli_set_charset($linkIdentifier, 'utf8');

        mysqli_select_db($linkIdentifier, $dataBaseName);

        $query = "SELECT `displayName`, `email` FROM `$dataBaseName`.`email-contacts`";

        $resultQuery = mysqli_query($linkIdentifier, $query);

        echo "Query issued: $query<br><br>\n";
        ?>
        
        <table>
            <thead>
                <tr><th>Display name</th><th>E-mail address</th></tr>
            </thead>
            <tfoot>
                <tr><th>Display name</th><th>E-mail address</th></tr>
            </tfoot>
            <?php
            while (( $record = mysqli_fetch_array( $resultQuery ) ) ) {

                echo "        <tr>\n";
                echo "          <td>" . $record[ 'displayName' ] . "</td>\n";
                echo "          <td>" . $record[ 'email' ] . "</td>\n";
                echo "        </tr>\n";
            }
            ?>
        </table>
        <?php
        mysqli_free_result($resultQuery);

        mysqli_close($linkIdentifier);
        ?>

        <br><a href="javascript: history.go(-1)">Back</a>
    </body>

</html>