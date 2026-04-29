<?php
    require_once( "../Lib/lib.php" );
    require_once( "../Lib/db.php" );
    require_once("ensureAuth.php");

    // Read from the data base the configuration details
    $configDetails = getConfiguration();
    $numColls = 0 + $configDetails['numColls'];

    $sessionUserId = isset($_SESSION['id']) ? $_SESSION['id'] : null;

    if (!is_int($sessionUserId) && !ctype_digit((string)$sessionUserId)) {
        http_response_code(403);
        exit("Invalid authenticated user");
    }

    // Read from the data base the list of the files
    $sessionUserId = (int)$sessionUserId;
    $files = getFilesByOwnerId($sessionUserId);
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

    foreach ($files as $imageData){

        $id = $imageData['id'];

        if($currCol == 1){
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

?>

        </table>
    </body>
</html>
