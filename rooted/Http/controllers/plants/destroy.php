<?php

use Core\App;
use Core\Database;
use Core\MediaService;

$db = App::resolve(Database::class);

$plant = $db
    ->query("SELECT * FROM plants WHERE id = :id", ["id" => $_GET["id"]])
    ->findOrFail();

$role = $_SESSION["user"]["role"];
$isOwner = $plant["user_id"] == $_SESSION["user"]["id"];
authorize($isOwner || in_array($role, ["moderator", "admin"]));

// Delete media files from disk
MediaService::deleteForPlant($plant["id"]);

// Delete plant (cascades to plant_tag, plant_meta via FK)
$db->query("DELETE FROM plants WHERE id = :id", ["id" => $plant["id"]]);

redirect("/plants");
