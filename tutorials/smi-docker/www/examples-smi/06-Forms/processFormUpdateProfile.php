<?php
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update user profile response - Forms App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <link rel="stylesheet" type="text/css" href="../Styles/GlobalStyle.css">
</head>
<body>
<?php
    require_once("../Lib/lib.php");
    require_once("../Lib/db.php");
    require_once("regex.php");


    $method = $_SERVER['REQUEST_METHOD'];

    if ($method == 'POST') {
        $_ARGS = $_POST;
    } else {
        $_ARGS = $_GET;
    }

    dbConnect(ConfigFile);
    $dataBaseName = $GLOBALS['configDataBase']->db;
    mysqli_select_db($GLOBALS['ligacao'], $dataBaseName);

    $queryString = "SELECT `settingName`, `settingValue` FROM `$dataBaseName`.`forms-upload-settings`";

    $queryResult = mysqli_query($GLOBALS['ligacao'], $queryString);

    $uploadDir = "";
    $maxFileSizePhoto = 0;
    $maxFileSizeUser = 0;

    if ($queryResult) {
        while ($registo = mysqli_fetch_array($queryResult)) {
            $settingName = $registo['settingName'];
            $settingValue = $registo['settingValue'];

            if ($settingName == 'upload_dir') {
                $uploadDir = $settingValue;
            }

            if ($settingName == 'max_file_size_photo') {
                $maxFileSizePhoto = (int)$settingValue;
            }
            if ($settingName == 'max_file_size_user') {
                $maxFileSizeUser = (int)$settingValue;
            }

        }
    }
    dbDisconnect();


    $alias = trim((string)(isset($_ARGS['alias']) ? $_ARGS['alias'] : ''));
    $password = trim((string)(isset($_ARGS['password']) ? $_ARGS['password'] : ''));
    $age = trim((string)(isset($_ARGS['age']) ? $_ARGS['age'] : ''));
    $district = trim((string)(isset($_ARGS['district']) ? $_ARGS['district'] : ''));
    $county = trim((string)(isset($_ARGS['county']) ? $_ARGS['county'] : ''));
    $zip = trim((string)(isset($_ARGS['zip']) ? $_ARGS['zip'] : ''));
    $comments = trim((string)(isset($_ARGS['comments']) ? $_ARGS['comments'] : ''));


    $errors = array();


    if (!preg_match(toPhpRegex(ALIAS_REGEX), $alias)) {
        $errors[] = "Alias must have 3 to 15 letters, numbers or underscore";
    }

    if (!preg_match(toPhpRegex(PASS_REGEX), $password)) {
        $errors[] = "Password must be between 6 and 15 chars, letters and number.";
    }

    if (!in_array($age, array('R1', 'R2', 'R3', 'R4'), true)) {
        $errors[] = "You must select an age range.";
    }

    if ($district === '') {
        $errors[] = "You must select a district";
    }

    if ($county === '') {
        $errors[] = "You must select a county.";
    }

    if ($zip === '') {
        $errors[] = "You must select a zip-code";
    }

    if (strlen($comments) > 200) {
        $errors[] = "Comment must be a max of 200 characters.";
    }

    $refreshtime = 5;

    if (!empty($errors)) {

        echo "<html>\n";
        echo "  <head>\n";
        echo "    <meta http-equiv=\"REFRESH\" content=\"$refreshtime;url=formUpdateProfile.php\">\n";
        echo "    <title>Forms - PHP App</title>\n";
        echo "  </head>\n";
        echo "  <body>\n";
        echo "    <p> Invalid data!";

        foreach ($errors as $error) {
            echo $error . "<br>\n";
        }

        echo "    <p> You will be redirected back to the profile page in $refreshtime seconds\n";
        echo "  </body>\n";
        echo "</html>";
        exit();
    }else{

        if (isset($_ARGS['alias'])) {
            echo "Alias: " . $_ARGS['alias'] . "<br>\n";
        }

        if (isset($_ARGS['password'])) {
            echo "Password: " . $_ARGS['password'] . "<br>\n";
        }

        if (isset($_ARGS['hobbyCars'])) {
            echo "hobbyCars: " . $_ARGS['hobbyCars'] . "<br>\n";
        }

        if (isset($_ARGS['hobbyTrains'])) {
            echo "hobbyTrains: " . $_ARGS['hobbyTrains'] . "<br>\n";
        }

        if (isset($_ARGS['age'])) {
            echo "Age: " . $_ARGS['age'] . "<br>\n";
        }

        if (isset($_ARGS['district'])) {
            echo "District: " . $_ARGS['district'] . "<br>\n";
        }

        if (isset($_ARGS['county'])) {
            echo "County: " . $_ARGS['county'] . "<br>\n";
        }

        if (isset($_ARGS['zip'])) {
            echo "Zip-Code: " . $_ARGS['zip'] . "<br>\n";
        }

        echo "<pre>";
        print_r($_FILES);
        echo "</pre>";

        // Maximum time allowed for processing request (including the upload)
        set_time_limit(60);

        function handleFile($fileData, $dest)
        {
            if ($fileData['error'] == 0) {

                // Name of the upload file in the temporary directory
                $localName = $fileData['tmp_name'];

                // Original name of the file that was uploaded
                $sourceName = basename($fileData['name']);

                // Directory where the file will be placed
                // Change to read from data base settings
                #$dest = "C:\\Temp\\upload\\";


                // Destination for the uploaded file
                $destName = $dest . $sourceName;

                echo "File: $localName<br>\n";
                echo "Original name of the file: $sourceName<br>\n";
                echo "Destination directory: $dest<br>\n";
                echo "Full destination name: $destName<br>\n";

                /* if ( copy( $localName, $destName) ) {
                   unlink( $localName );*/

                if (move_uploaded_file($localName, $destName)) {

                    $destName = addslashes($destName);
                    echo "Destination name with slashes: $destName<br>\n";
                } else {
                    echo "Could not write file to $dest";
                }
            } else {
                $errrorMsg = showUploadFileError($fileData['error']);
                echo "Error receiveing file.\n<br>Details: $errrorMsg";
            }

            echo "<br>";
        }


        if (isset($_FILES['imagePhoto'])) {
            if ($_FILES['imagePhoto']['size'] <= $maxFileSizePhoto) {
                handleFile($_FILES['imagePhoto'], $uploadDir);
            } else {
                echo "imagePhoto exceeds maximum allowed size.<br>\n";
            }
        }

        if (isset($_FILES['imageUser'])) {
            if ($_FILES['imageUser']['size'] <= $maxFileSizeUser) {
                handleFile($_FILES['imageUser'], $uploadDir);
            } else {
                echo "imageUser exceeds maximum allowed size.<br>\n";
            }

    }

}


/*foreach ($_FILES as $currentFile) {
  handleFile( $currentFile, $uploadDir );
}

/*
if ( $_FILES['imagePhoto']['error']==0 ) {
  
// Name of the upload file in the temporary directory
  $localName = $_FILES['imagePhoto']['tmp_name'];

  // Original name of the file that was uploaded
  $sourceName = $_FILES['imagePhoto']['name'];

  // Directory where the file will be placed
  // Change to read from data base settings
  #$dest = "C:\\Temp\\upload\\";
  $dest = "/tmp/upload/";
  
  // Destination for the uploaded file
  $destName = $dest . $sourceName;

  echo "File: $localName<br>\n";
  echo "Original name of the file: $sourceName<br>\n";
  echo "Destination directory: $dest<br>\n";
  echo "Full destination name: $destName<br>\n";

  if ( copy( $localName, $destName) ) {
    unlink( $localName );
  
    $destName = addslashes( $destName );
    echo "Destination name with slashes: $destName<br>\n";
  }
  else {
    echo "Could not write file to $dest";
  }
}
else {
  $errrorMsg = showUploadFileError( $_FILES['imagePhoto']['error'] );
  echo "Error receiveing file.\n<br>Details: $errrorMsg";
}
 */
?>
</body>
</html>