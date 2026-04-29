<?php
require_once("../Lib/lib.php");
require_once("../Lib/db.php");
require_once("ensureAuth.php");

$id = isset($_POST['id']) ? $_POST['id'] : null;

if(!ctype_digit((string)$id)){
    http_response_code(400);
    exit("Invalid file id");
}

$id = (int)$id;

$sessionUserId = isset($_SESSION['id']) ? (int)$_SESSION['id'] : 0;

$fileDetails = getFileDetails($id);

if(!$fileDetails){
    http_response_code(404);
    exit("File not found");
}

$fileOwnerId = isset($fileDetails['ownerId']) ? (int)$fileDetails['ownerId'] : 0;

if($fileOwnerId !== $sessionUserId){
    http_response_code(403);
    exit("You do not have permission to update this file");
}

$latitude = isset($_POST['latitude']) ? trim($_POST['latitude']) : '';
$longitude = isset($_POST['longitude']) ? trim($_POST['longitude']) : '';
$title = isset($_POST['title']) ? trim($_POST['title']) : '';
$description = isset($_POST['description']) ? trim($_POST['description']) : '';


$result = updateFileDetails($id, $latitude, $longitude, $title, $description);

if(!$result['ok']){
    http_response_code(500);
    exit("Could not update file properties");
}

header("Location: showFile.php?id=" . $id);
exit(0);

?>
