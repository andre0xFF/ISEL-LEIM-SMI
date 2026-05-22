<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$userId = $_SESSION["user"]["id"];
$gardenPlantId = (int) ($_GET["id"] ?? 0);

if ($gardenPlantId <= 0) {
    abort(404);
}

$gardenPlant = $db->query(
    "SELECT
        gp.id,
        gp.notes,
        gp.created_at AS garden_created_at,
        p.id AS plant_id,
        p.name,
        p.body,
        p.visibility
     FROM garden_plants gp
     JOIN plants p ON p.id = gp.plant_id
     WHERE gp.id = :id AND gp.user_id = :user_id",
    [
        "id" => $gardenPlantId,
        "user_id" => $userId,
    ],
)->find();

if (!$gardenPlant) {
    abort(404);
}

$media = $db->query(
    "SELECT *
     FROM garden_media
     WHERE garden_plant_id = :garden_plant_id
     ORDER BY created_at DESC",
    [
        "garden_plant_id" => $gardenPlantId,
    ],
)->get();

view("garden/show.view.php", [
    "heading" => $gardenPlant["name"],
    "gardenPlant" => $gardenPlant,
    "media" => $media,
]);