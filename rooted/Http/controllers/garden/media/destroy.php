<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$userId = $_SESSION["user"]["id"];
$mediaId = (int) ($_GET["id"] ?? 0);

if ($mediaId <= 0) {
    abort(404);
}

$media = $db->query(
    "SELECT
        gm.id,
        gm.path,
        gm.garden_plant_id
     FROM garden_media gm
     JOIN garden_plants gp ON gp.id = gm.garden_plant_id
     WHERE gm.id = :id AND gp.user_id = :user_id",
    [
        "id" => $mediaId,
        "user_id" => $userId,
    ],
)->find();

if (!$media) {
    abort(404);
}

$absolutePath = base_path("storage/app/" . $media["path"]);

if (file_exists($absolutePath)) {
    unlink($absolutePath);
}

$db->query(
    "DELETE FROM garden_media WHERE id = :id",
    [
        "id" => $mediaId,
    ],
);

$_SESSION["_flash"]["success"] = "Media removed from your garden album.";

redirect("/garden-plant?id=" . $media["garden_plant_id"]);