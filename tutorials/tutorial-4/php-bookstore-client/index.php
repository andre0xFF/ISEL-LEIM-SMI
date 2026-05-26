<!DOCTYPE html>
<html>
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <title>REST Client - BookStore</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <script type="text/javascript" src="scripts/forms.js"></script>

    <link REL="stylesheet" TYPE="text/css" href="../Styles/GlobalStyle.css">
</head>

<body onload="init()">

<h2>REST Client &mdash; BookStore</h2>

<p><b>Note 1:</b> Please ensure that the PHP cURL extension is enabled:</p>
<p><code>extension=curl</code> in <code>php.ini</code></p>

<p><b>Note 2:</b> Book store locations are specified in <code>services.xml</code>.
New locations can be manually entered in the text field below.</p>

<hr>

<h3>Book Store Client</h3>

<?php
ini_set("display_errors", "On");
error_reporting(E_ALL);

$services = simplexml_load_file("services.xml");

if ($services === false) {
    echo "<p style='color:red;'>Error: Could not load <code>services.xml</code>.</p>";
    exit();
}

$description = $services->Description;
$locations = $services->Locations[0];

echo "<p>Available locations for <em>$description</em>:</p>\n";
?>

<form action="processClientBookStore.php" method="POST">
    <table>
        <tr>
            <td>
                <select size="1" name="uris" id="uris" onchange="selectChanged('uris', 'uri')">
                    <?php
                    $first = true;
                    foreach ($locations as $currentLocation) {
                        $selected = $first ? " selected" : "";
                        echo "<option$selected value=\"$currentLocation\">$currentLocation</option>\n";
                        $first = false;
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
    <input type="submit" value="List Available Books">
    <input type="reset" value="Clear">
</form>

</body>
</html>
