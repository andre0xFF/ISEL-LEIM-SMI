<?php
    require_once( "../Lib/lib.php" );
    require_once( "../Lib/db.php" );
    require_once("ensureAuth.php");

    // TODO validate input data
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if (!$id) {
        http_response_code(400);
        exit("Invalid id");
    }

    // Read from the data base details about the file
    $fileDetails = getFileDetails($id);
    if (!$fileDetails) {
        http_response_code(404);
        exit("File not found");
    }

    $sessionUserId = isset($_SESSION['id']) ? $_SESSION['id'] : null;

    if (!is_int($sessionUserId) && !ctype_digit((string)$sessionUserId)) {
        http_response_code(403);
        exit("Invalid authenticated user");
    }

    $sessionUserId = (int)$sessionUserId;
    $fileOwnerId = isset($fileDetails['ownerId']) ? $fileDetails['ownerId'] : null;

    if (!is_int($fileOwnerId) && !ctype_digit((string)$fileOwnerId)) {
        http_response_code(500);
        exit("Stored file has no valid owner");
    }

    $fileOwnerId = (int)$fileOwnerId;

    if ($fileOwnerId !== $sessionUserId) {
        http_response_code(403);
        exit("You do not have permission to access this file");
    }

    $imageFileNameAux = isset($fileDetails['imageFileName']) ? $fileDetails['imageFileName'] : '';
    $imageMimeFileName = isset($fileDetails['imageMimeFileName']) ? $fileDetails['imageMimeFileName'] : '';
    $imageTypeFileName = isset($fileDetails['imageTypeFileName']) ? $fileDetails['imageTypeFileName'] : '';

    if ($imageFileNameAux === '') {
        http_response_code(500);
        exit("Invalid stored preview image path");
    }

    if (!file_exists($imageFileNameAux) || !is_readable($imageFileNameAux)) {
        http_response_code(404);
        exit("Stored preview image not available");
    }

    if ($imageMimeFileName === '' || $imageTypeFileName === '') {
        http_response_code(500);
        exit("Invalid stored preview image metadata");
    }

    header( "Content-type: $imageMimeFileName/$imageTypeFileName" );
    header( "Content-Length: " . filesize( $imageFileNameAux ) );

    $thumbFileHandler = fopen( $imageFileNameAux, 'rb' );
    fpassthru( $thumbFileHandler );
    fclose( $thumbFileHandler );
?>
