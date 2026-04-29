<?php

require_once("../Lib/lib.php");
require_once("../Lib/db.php");
require_once("../Lib/lib-coords.php");
require_once("../Lib/ImageResize.php");

include_once("config.php");
include_once("configDebug.php");
require_once("ensureAuth.php");

$errorMsg = null;
$successMsg = null;
$dbMsg = null;
$messages = array();
$debugBlocks = array();

$dst = null;
$srcName = null;
$userId = null;
$mimeFileName = null;
$typeFileName = null;
$imageFileNameAux = null;
$imageMimeFileName = null;
$imageTypeFileName = null;
$thumbFileNameAux = null;
$thumbMimeFileName = null;
$thumbTypeFileName = null;
$lat = "";
$lon = "";

set_time_limit(300);

if (!isset($_FILES['userFile'])) {
    $errorMsg = "No file was submitted.";
}

if ($errorMsg === null && $_FILES['userFile']['error'] != 0) {
    $errorMsg = showUploadFileError($_FILES['userFile']['error']);
}

if ($errorMsg === null) {

    $userId = isset($_SESSION['id']) ? $_SESSION['id'] : null;

    if(!is_int($userId) && !ctype_digit((string)$userId)){
        $errorMsg = "Invalid authenticated user.";
    }else{
        $userId = (int)$userId;
        $srcName = basename($_FILES['userFile']['name']);

        $src = $_FILES['userFile']['tmp_name'];
        $configurations = getConfiguration();

        $baseDir =rtrim($configurations['destination'], DIRECTORY_SEPARATOR);

        $userDir = $baseDir . DIRECTORY_SEPARATOR . "user_" . $userId;
        $thumbsDir = $userDir . DIRECTORY_SEPARATOR . "thumbs";

        if(!is_dir($userDir) && !mkdir($userDir, 0775, true)){
            $errorMsg = "Could not create user directory";
        }

        if($errorMsg === null && !is_dir($thumbsDir) && !mkdir($thumbsDir, 0775, true)){
            $errorMsg = "Could not create thumbs directory";
        }

        if($errorMsg === null){
            $ext = strtolower(pathinfo($srcName, PATHINFO_EXTENSION));
            $originalBaseName = pathinfo($srcName, PATHINFO_FILENAME);
            $originalBaseName = preg_replace('/[^A-Za-z0-9._-]/', '_', $originalBaseName);

            $randomBytes = openssl_random_pseudo_bytes(4);
            if ($randomBytes === false) {
                $errorMsg = "Could not generate a unique file name.";
            } else {
                $uniqueSuffix = bin2hex($randomBytes);
                $storedBaseName = date('Ymd_His') . "_" . $uniqueSuffix;

                if ($originalBaseName !== '') {
                    $storedBaseName .= "_" . $originalBaseName;
                }

                $storedFileName = $storedBaseName;
                if ($ext !== '') {
                    $storedFileName .= "." . $ext;
                }

                $dst = $userDir . DIRECTORY_SEPARATOR . $storedFileName;

                if (!move_uploaded_file($src, $dst)) {
                    $errorMsg = "Could not move uploaded file to '$dst'";
                }
            }
        }

    }
}

if ($errorMsg === null) {
    $fileInfo = finfo_open(FILEINFO_MIME);
    $fileInfoData = finfo_file($fileInfo, $dst);
    finfo_close($fileInfo);

    if ($debug == true) {
        $debugBlocks[] = $fileInfoData;
    }

    $fileTypeComponents = explode(";", $fileInfoData);
    $mimeTypeFileUploaded = explode("/", $fileTypeComponents[0]);

    $mimeFileName = isset($mimeTypeFileUploaded[0]) ? $mimeTypeFileUploaded[0] : "";
    $typeFileName = isset($mimeTypeFileUploaded[1]) ? $mimeTypeFileUploaded[1] : "";

    if ($mimeFileName === "" || $typeFileName === "") {
        $errorMsg = "Could not determine uploaded file type.";
    } else {
        $messages[] = "File is of type $mimeFileName.";
    }
}

if ($errorMsg === null) {
    $pathParts = pathinfo($dst);

    if ($_POST['description'] != NULL) {
        $description = $_POST['description'];
    } else {
        $description = "No description available";
    }

    if ($_POST['title'] != NULL) {
        $title = $_POST['title'];
    } else {
        $pathPartsTitle = pathinfo($srcName);
        $title = $pathPartsTitle['filename'];
    }

    $width = $configurations['thumbWidth'];
    $height = $configurations['thumbHeight'];

    switch ($mimeFileName) {
        case "image":
            if (function_exists('exif_read_data') && ($typeFileName === 'jpeg' || $typeFileName === 'jpg')) {
                $exif = @exif_read_data($dst, 'IFD0', true);
            } else {
                $exif = false;
            }

            if ($exif === false) {
                $messages[] = "No exif header data found.";
            } else {
                if ($debug == true) {
                    $debugBlocks[] = print_r($exif, true);
                }

                $gps = @$exif['GPS'];
                if ($gps != NULL) {
                    $latitudeAux = $gps['GPSLatitude'];
                    $latitudeRef = $gps['GPSLatitudeRef'];
                    $longitudeAux = $gps['GPSLongitude'];
                    $longitudeRef = $gps['GPSLongitudeRef'];

                    if (($latitudeAux != NULL) && ($longitudeAux != NULL)) {
                        if ($debug == true) {
                            $debugBlocks[] =
                                    '$latitudeAux: ' . print_r($latitudeAux, true) . "\n" .
                                    '$latitudeRef: ' . print_r($latitudeRef, true) . "\n" .
                                    '$longitudeAux: ' . print_r($longitudeAux, true) . "\n" .
                                    '$longitudeRef: ' . print_r($longitudeRef, true);
                        }

                        $lat = getCoordFromEXIF($latitudeAux, $latitudeRef);
                        $lon = getCoordFromEXIF($longitudeAux, $longitudeRef);

                        $messages[] = "File latitude: $lat";
                        $messages[] = "File longitude: $lon";
                    } else {
                        $messages[] = "File include GPS information.";
                    }
                } else {
                    $messages[] = "File does not have GPS information.";
                }
            }

            $imageFileNameAux = $dst;
            $imageMimeFileName = "image";
            $imageTypeFileName = $typeFileName;

            $thumbFileNameAux = $thumbsDir . DIRECTORY_SEPARATOR . $pathParts['filename'] . "." . $typeFileName;
            $thumbMimeFileName = "image";
            $thumbTypeFileName = $typeFileName;

            $resizeObj = new ImageResize($dst);
            $resizeObj->resizeImage($width, $height, 'crop');
            $resizeObj->saveImage($thumbFileNameAux, $typeFileName, 100);
            $resizeObj->close();
            break;

        case "video":
            $size = $width . "x" . $height;

            $imageFileNameAux = $thumbsDir . DIRECTORY_SEPARATOR . $pathParts['filename'] . "-Large.jpg";
            $imageMimeFileName = "image";
            $imageTypeFileName = "jpeg";
            $messages[] = "Generating video 1st image...";

            $ffmpeg = escapeshellarg($ffmpegBinary);
            $srcArg = escapeshellarg($dst);

            $imageArg = escapeshellarg($imageFileNameAux);



            $cmdFirstImage = "$ffmpeg -itsoffset -1 -i $srcArg -vcodec mjpeg -vframes 1 -an -f rawvideo -s 640x480 $imageArg";
            $messages[] = $cmdFirstImage;
            system($cmdFirstImage, $status);
            $messages[] = "Status from the generation of video 1st image: $status.";

            $thumbFileNameAux = $thumbsDir . DIRECTORY_SEPARATOR . $pathParts['filename'] . ".jpg";
            $thumbMimeFileName = "image";
            $thumbTypeFileName = "jpeg";
            $messages[] = "Generating video thumb...";

            $thumbArg = escapeshellarg($thumbFileNameAux);

            $cmdVideoThumb = "$ffmpeg -itsoffset -1 -i $srcArg -vcodec mjpeg -vframes 1 -an -f rawvideo -s $size $thumbArg";
            $messages[] = $cmdVideoThumb;
            system($cmdVideoThumb, $status);
            $messages[] = "Status from the generation of video thumb: $status.";
            break;

        case "audio":
            require_once("Zend/Media/Id3v2.php");

            $id3 = new Zend_Media_Id3v2($dst);

            $mimeTypeAudioAPIC = explode("/", $id3->apic->mimeType);
            $typeAudioAPIC = $mimeTypeAudioAPIC[1];

            $imageFileNameAux = $thumbsDir . DIRECTORY_SEPARATOR . $pathParts['filename'] . "-Large." . $typeAudioAPIC;
            $imageMimeFileName = "image";
            $imageTypeFileName = $typeAudioAPIC;
            $fdMusicImage = fopen($imageFileNameAux, "wb");
            fwrite($fdMusicImage, $id3->apic->getImageData());
            fclose($fdMusicImage);

            $thumbFileNameAux = $thumbsDir . DIRECTORY_SEPARATOR . $pathParts['filename'] . "." . $typeAudioAPIC;
            $thumbMimeFileName = "image";
            $thumbTypeFileName = $typeAudioAPIC;
            $resizeObj = new ImageResize($imageFileNameAux);
            $resizeObj->resizeImage($width, $height, 'crop');
            $resizeObj->saveImage($thumbFileNameAux, $typeAudioAPIC, 100);
            $resizeObj->close();
            break;

        default:
            $imageFileNameAux = $baseDir . DIRECTORY_SEPARATOR . "default" . DIRECTORY_SEPARATOR . "Unknown-Large.jpg";
            $imageMimeFileName = "image";
            $imageTypeFileName = "jpeg";

            $thumbFileNameAux = $baseDir . DIRECTORY_SEPARATOR . "default" . DIRECTORY_SEPARATOR . "Unknown.jpg";
            $thumbMimeFileName = "image";
            $thumbTypeFileName = "jpeg";
            break;
    }
}

if ($errorMsg === null) {

    $result = insertFileDetails(
            $dst,
            $mimeFileName,
            $typeFileName,
            $imageFileNameAux,
            $imageMimeFileName,
            $imageTypeFileName,
            $thumbFileNameAux,
            $thumbMimeFileName,
            $thumbTypeFileName,
            $lat,
            $lon,
            $title,
            $description,
            $userId);

    if (!$result['ok']) {
        $dbMsg = "Information about file could not be inserted into the data base. Details: " . $result['error'];
        $errorMsg = "Information about file could not be inserted into the data base.";
    } else {
        $dbMsg = "Information about file was inserted into data base.";
        $successMsg = "File uploaded with success.";
    }

}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Image Processing</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" type="text/css" href="../Styles/GlobalStyle.css">
</head>

<body>
<?php if ($errorMsg !== null) { ?>
    <p><?php echo htmlspecialchars($errorMsg, ENT_QUOTES, 'UTF-8'); ?></p>
<?php } ?>

<?php if ($successMsg !== null) { ?>
    <p><?php echo htmlspecialchars($successMsg, ENT_QUOTES, 'UTF-8'); ?></p>
<?php } ?>

<?php foreach ($messages as $message) { ?>
    <p><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></p>
<?php } ?>

<?php foreach ($debugBlocks as $debugBlock) { ?>
    <pre><?php echo htmlspecialchars($debugBlock, ENT_QUOTES, 'UTF-8'); ?></pre>
<?php } ?>

<?php if ($dbMsg !== null) { ?>
    <p><?php echo htmlspecialchars($dbMsg, ENT_QUOTES, 'UTF-8'); ?></p>
<?php } ?>

<p><a href="javascript:history.back()">Back</a></p>
</body>
</html>
