<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>

        <title>Accessing REST Web Services using PHP - Book Store Client</title>

        <script type="text/javascript" src="scripts/forms.js">
        </script>

        <link REL="stylesheet" TYPE="text/css" href="../Styles/GlobalStyle.css">
    </head>

    <body onload="init()">
        <p><b>Note 1:</b></p>
        <?php
        ini_set('display_errors', 'On');

        error_reporting(E_ALL);

        require_once( "../Lib/db.php" );

        $pathConfigFile = ConfigFile;

        echo "    <p>Please ensure that PHP extention for CURL is enable:</p>\n<br>";

        echo "    <code>extension=curl</code> in \"php.ini\" file +/- line 914\n<br>";
        ?>
        <p><b>Note 2:</b></p>
        <p>Book store locations are specified in file <b><code>services.xml</code></b></p>

        <p>New locations can be manually specified in the text field.</p>

        <p><b>Book store client:</b></p>
        <?php
        $services = simplexml_load_file("services.xml");

        $description = $services->Description;
        $locations = $services->Locations[0];

        echo "    <p>Available locations for <i>" . $description . "</i>:<p>\n";
        ?>
        <form action="processClientBookStore.php" method="POST">
            <table>
                <tr>
                    <td>
                        <select size="1" name="uris" id="uris" onchange="selectChanged('uris', 'uri')">
                            <?php
                            $first = true;
                            foreach ($locations as $currentlocation) {
                                if ($first == true) {
                                    echo "              <option selected value=\"$currentlocation\">$currentlocation</option>\n";
                                    $first = false;
                                } else {
                                    echo "              <option value=\"$currentlocation\">$currentlocation</option>\n";
                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>
                        <p>Location selected:</p>
                        <input type="text" size="100" value="" name="uri" id="uri">
                    </td>
                </tr>

            </table>

            <br>

            <input type="submit" value="List Available Books"> <input type="reset" value="Clear">
        </form>

    </body>
</html>