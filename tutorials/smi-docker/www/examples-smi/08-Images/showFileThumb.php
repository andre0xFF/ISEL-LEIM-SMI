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


    $thumbFileNameAux = isset($fileDetails['thumbFileName']) ? $fileDetails['thumbFileName'] : '';
    $thumbMimeFileName = isset($fileDetails['thumbMimeFileName']) ? $fileDetails['thumbMimeFileName'] : '';
    $thumbTypeFileName = isset($fileDetails['thumbTypeFileName']) ? $fileDetails['thumbTypeFileName'] : '';

    if ($thumbFileNameAux === '') {
        http_response_code(500);
        exit("Invalid stored thumbnail path");
    }

    if (!file_exists($thumbFileNameAux) || !is_readable($thumbFileNameAux)) {
        http_response_code(404);
        exit("Stored thumbnail not available");
    }

    if ($thumbMimeFileName === '' || $thumbTypeFileName === '') {
        http_response_code(500);
        exit("Invalid stored thumbnail metadata");
    }


    header( "Content-type: $thumbMimeFileName/$thumbTypeFileName");
    header( "Content-Length: " . filesize($thumbFileNameAux) );

    $thumbFileHandler = fopen( $thumbFileNameAux, 'rb' );
    fpassthru( $thumbFileHandler );

    fclose( $thumbFileHandler );
?>
