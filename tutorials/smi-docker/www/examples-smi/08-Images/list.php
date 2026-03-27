<?php
    require_once( "../Lib/lib.php" );
    require_once( "../Lib/db.php" );

    // Read from the data base the configuration details
    $configDetails = getConfiguration();
    $numColls = 0 + $configDetails['numColls'];

    // Read from the data base the list of the files
    dbConnect(ConfigFile);
    mysqli_select_db( $GLOBALS['ligacao'], $GLOBALS['configDataBase']->db);
    $query = "SELECT `id`, `fileName` FROM `images-details`";
    $result = mysqli_query($GLOBALS['ligacao'], $query);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>Image Processing</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <link rel="stylesheet" type="text/css" href="../Styles/GlobalStyle.css">
    </head>

    <body>
        <h1 align="center">Available files</h1>

        <table border="1" align="center" cellspacing="<?php echo $configDetails['cellspacing'] ?>">

<?php
    $currCol = 1;

    while ($imageData = mysqli_fetch_array($result)) {
        $id = $imageData['id'];

        if ($currCol == 1) {
            echo "<tr>\n";
        }

        $target = "<img src=\"showFileThumb.php?id=$id\">";
        echo "<td><a href='showFile.php?id=$id'>$target</a></td>\n";

        if ($currCol == $numColls) {
            echo "</tr>\n";
            $currCol = 1;
        } else {
            ++$currCol;
        }
    }

    mysqli_free_result($result);
    dbDisconnect();
?>

        </table>
    </body>
</html>