<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$userId = $_SESSION["user"]["id"];
$gardenPlantId = (int) ($_POST["garden_plant_id"] ?? 0);

if ($gardenPlantId <= 0) {
    abort(404);
}

$gardenPlant = $db->query(
    "SELECT id
     FROM garden_plants
     WHERE id = :id AND user_id = :user_id",
    [
        "id" => $gardenPlantId,
        "user_id" => $userId,
    ],
)->find();

if (!$gardenPlant) {
    abort(404);
}

if (
    empty($_FILES["media"]["tmp_name"]) ||
    $_FILES["media"]["error"] !== UPLOAD_ERR_OK
) {
    $_SESSION["_flash"]["errors"] = [
        "media" => "Please upload a valid file.",
    ];

    return redirect("/garden-plant?id=" . $gardenPlantId);
}

$storagePath = base_path("storage/app/garden-media/");
if (!is_dir($storagePath)) {
    mkdir($storagePath, 0755, true);
}

$originalName = $_FILES["media"]["name"];
$tmpPath = $_FILES["media"]["tmp_name"];
$mimeType = mime_content_type($tmpPath) ?: "application/octet-stream";

$type = "image";
if (str_starts_with($mimeType, "video/")) {
    $type = "video";
} elseif (str_starts_with($mimeType, "audio/")) {
    $type = "audio";
}

$extension = pathinfo($originalName, PATHINFO_EXTENSION);
$filename = uniqid("", true) . ($extension ? "." . $extension : "");
$relativePath = "garden-media/" . $filename;
$absolutePath = base_path("storage/app/" . $relativePath);

if (!move_uploaded_file($tmpPath, $absolutePath)) {
    $_SESSION["_flash"]["errors"] = [
        "media" => "Could not save the uploaded file.",
    ];

    return redirect("/garden-plant?id=" . $gardenPlantId);
}

$db->query(
    "INSERT INTO garden_media (garden_plant_id, type, path, filename, mime_type)
     VALUES (:garden_plant_id, :type, :path, :filename, :mime_type)",
    [
        "garden_plant_id" => $gardenPlantId,
        "type" => $type,
        "path" => $relativePath,
        "filename" => $originalName,
        "mime_type" => $mimeType,
    ],
);

$_SESSION["_flash"]["success"] = "Media uploaded successfully.";

redirect("/garden-plant?id=" . $gardenPlantId);