<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>Accessing Web Services using PHP - Generic Client</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <script type="text/javascript" src="scripts/forms.js">
        </script>

        <link rel="stylesheet" type="text/css" href="../Styles/GlobalStyle.css"> 
    </head>

    <body onload="init()">
        <?php
        $services = simplexml_load_file("services.xml");

        $description = $services->Description;
        $locations = $services->Locations[0];

        echo "Available locations for <i>" . $description . "</i>";
        ?>
        <form action="processClientSoap.php" method="POST">
            <table>
                <tr>
                    <td>
                        <select size="1" name="wsdls" id="wsdls" onchange="selectChanged('wsdls', 'wsdl')">
                            <?php
                            $first = true;
                            foreach ($locations as $currentlocation) {

                                if ($first == true) {
                                    echo "<option selected value=\"$currentlocation\">$currentlocation</option>\n";
                                    $first = false;
                                } else {
                                    echo "<option value=\"$currentlocation\">$currentlocation</option>\n";
                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="text" size="100" value="" name="wsdl" id="wsdl">
                    </td>
                </tr>

            </table>

            <input type="submit" value="Create Proxy">
        </form>
    </body>
</html>
