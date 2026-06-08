<?php
use Core\App;
use Core\Database;
use Core\MediaService;

$id = (int) ($_GET["id"] ?? 0);

if ($id <= 0) {
    abort(404);
}

$db = App::resolve(Database::class);


$media = $db->query(
    "SELECT m.*,
    p.visibility
    FROM media m
    JOIN plants p ON p.id = m.plant_id
    WHERE m.id = :id",[
        "id"=> $id,
    ])->find();

$isGuest = !($_SESSION["user"] ?? false);



if ($media["visibility"] === "internal" && $isGuest) {
    abort(403);
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
