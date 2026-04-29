<?php
    require_once( "../Lib/lib.php" );
    require_once( "../Lib/db.php" );

    require_once("ensureAuth.php");

    $id = filter_input(INPUT_GET,'id', FILTER_VALIDATE_INT);

    if(!$id){
        http_response_code(400);
        exit("Invalid id");
    }

    // Read from the data base details about the file
    $fileDetails = getFileDetails( $id );

    if (!$fileDetails) {
        http_response_code(404);
        exit("File not found");
    }

    $sessionUserId = isset($_SESSION['id']) ? $_SESSION['id'] : null;

    if(!is_int($sessionUserId) &&  !ctype_digit((string)$sessionUserId)){
        http_response_code(403);
        exit("Invalid authenticated user");
    }

    $sessionUserId = (int)$sessionUserId;
    $fileOwnerId = isset($fileDetails['ownerId']) ? $fileDetails['ownerId'] : null;

    if (!is_int($fileOwnerId) && !ctype_digit((string)$fileOwnerId)) {
        http_response_code(500);
        exit("Stored file has no valid owner");
    }

    $fileOwnerId = (int) $fileOwnerId;

    if($fileOwnerId !== $sessionUserId){
        http_response_code(403);
        exit("You do not have permission to access this file");
    }


    $fileName = $fileDetails['fileName'];

    if (!is_string($fileName) || !file_exists($fileName) || !is_readable($fileName)) {
        http_response_code(404);
        exit("Stored file not available");
    }

    $mimeFileName = isset($fileDetails['mimeFileName']) ? $fileDetails['mimeFileName'] : '';
    $typeFileName = isset($fileDetails['typeFileName']) ? $fileDetails['typeFileName'] : '';

    if ($mimeFileName === '' || $typeFileName === '') {
        http_response_code(500);
        exit("Invalid stored file metadata");
    }

    $pathParts = pathinfo( $fileName );


    $downloadBaseName = isset($fileDetails['title']) ? $fileDetails['title'] : 'download';
    $downloadBaseName = preg_replace('/[^A-Za-z0-9._-]/', '_', $downloadBaseName);

    if($downloadBaseName === ''){
        $downloadBaseName = 'download';
    }

    $extension = isset($pathParts['extension']) ? $pathParts['extension'] : '';
    $fileNameForDownload = $downloadBaseName;

    if($extension !== ''){
        $fileNameForDownload .= "." . $extension;
    }



    // Pass image contents to the browser
    $fileHandler = fopen($fileName, 'rb');

    header( "Content-Type: $mimeFileName/$typeFileName");
    header( "Content-Length: " . filesize($fileName) );

    header( "Content-Transfer-Encoding: Binary" );
    header( "Content-Disposition: attachment; filename=\"" . $fileNameForDownload . "\""); 
    
    //header( "Content-Disposition: attachment; "); 

    fpassthru( $fileHandler );
    fclose( $fileHandler );
?>
