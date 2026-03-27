<?php
    require_once( "../Lib/lib.php" );
    require_once( "../Lib/db.php" );

    // TODO validate input data
    $id = $_GET['id'];

    // Read from the data base details about the file
    $fileDetails = getFileDetails( $id );

    $imageFileNameAux = $fileDetails[ 'imageFileName' ];
    $imageMimeFileName = $fileDetails[ 'imageMimeFileName' ];
    $imageTypeFileName = $fileDetails[ 'imageTypeFileName' ];

    header( "Content-type: $imageMimeFileName/$imageTypeFileName" );
    header( "Content-Length: " . filesize( $imageFileNameAux ) );

    $thumbFileHandler = fopen( $imageFileNameAux, 'rb' );
    fpassthru( $thumbFileHandler );
    fclose( $thumbFileHandler );
?>
