<?php

use Core\MediaService;

$id = $_GET["id"] ?? null;

if (!$id) {
    abort(404);
}

$media = MediaService::find((int) $id);

if (!$media) {
    abort(404);
}

$path = BASE_PATH . "storage/app/" . $media["path"];

if (!file_exists($path)) {
    abort(404);
}

header("Content-Type: " . $media["mime_type"]);
header("Content-Disposition: inline; filename=\"" . $media["filename"] . "\"");
header("Content-Length: " . filesize($path));
readfile($path);
exit();
