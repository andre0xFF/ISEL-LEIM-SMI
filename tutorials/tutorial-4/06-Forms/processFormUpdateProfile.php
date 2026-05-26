<!DOCTYPE html>
<?php
header( 'Content-Type: text/html; charset=utf-8' );
?>
        <title>Update user profile response - Forms App</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    
        <link rel="stylesheet" type="text/css" href="../Styles/GlobalStyle.css">
    </head>
    </body>
<?php
require_once( "../Lib/lib.php" );
require_once( "vars.php" );

echo "$x\n<br>";

$method = $_SERVER[ 'REQUEST_METHOD' ];

if ( $method=='POST') {
	$_ARGS = $_POST;
} else {
	$_ARGS = $_GET;
}

if ( isset($_ARGS['alias']) ) {
  echo "Alias: " . $_ARGS['alias'] . "<br>\n";
}

if ( isset($_ARGS['password']) ) {
  echo "Password: " . $_ARGS['password'] . "<br>\n";
}

if ( isset($_ARGS['hobbyCars']) ) {
  echo "hobbyCars: " . $_ARGS['hobbyCars'] . "<br>\n";
}

if ( isset($_ARGS['hobbyTrains']) ) {
  echo "hobbyTrains: " . $_ARGS['hobbyTrains'] . "<br>\n";
}

if ( isset($_ARGS['age']) ) {
  echo "Age: " . $_ARGS['age'] . "<br>\n";
}

if ( isset($_ARGS['district']) ) {
  echo "District: " . $_ARGS['district'] . "<br>\n";
}

if ( isset($_ARGS['county']) ) {
  echo "County: " . $_ARGS['county'] . "<br>\n";
}

if ( isset($_ARGS['zip']) ) {
  echo "Zip-Code: " . $_ARGS['zip'] . "<br>\n";
}

echo "<pre>";
print_r($_FILES);
echo "</pre>";

// Maximum time allowed for processing request (including the upload)
set_time_limit(60);

function handleFile($fileData) {
  if ( $fileData['error']==0 ) {
    
    // Name of the upload file in the temporary directory
    $localName = $fileData['tmp_name'];

    // Original name of the file that was uploaded
    $sourceName = $fileData['name'];

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
  
  echo "<br>";
}

foreach ($_FILES as $currentFile) {
  handleFile( $currentFile );
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