<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>MySQL - Example 1 - Read (Divs)</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <link rel="stylesheet" type="text/css" href="../Styles/GlobalStyle.css">

        <link rel="stylesheet" type="text/css" href="../Styles/TableUsingDivs.css">
    </head>

    <body>
        <h1 align="center">MySQL - Example 1 - Read - Display using tag <code>div</code> </h1>
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
        <div class="rTable">
            <div class="rTableRow">
                <div class="rTableHead">Display name</div><div class="rTableHead">E-mail address</div>
            </div>
            <?php
            while (($record = mysqli_fetch_array($resultQuery))) {

                echo "      <div class=\"rTableRow\">\n";
                echo "        <div class=\"rTableCell\">" . $record['displayName'] . "</div>\n";
                echo "        <div class=\"rTableCell\">" . $record['email'] . "</div>\n";
                echo "      </div>\n";
            }
            ?>
            <div class="rTableRow">
                <div class="rTableFoot">Display name</div><div class="rTableFoot">E-mail address</div>
            </div>
        </div>

        <?php
        mysqli_free_result($resultQuery);

        mysqli_close($linkIdentifier);
        ?>

        <br><a href="javascript: history.go(-1)">Back</a>
    </body>

</html>