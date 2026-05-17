<?php

use Core\App;
use Core\Database;
use Core\MediaService;

$db = App::resolve(Database::class);

$plant = $db
    ->query("SELECT * FROM plants WHERE id = :id", ["id" => $_GET["id"]])
    ->findOrFail();

// Allow if author, moderator, or admin
$role = $_SESSION["user"]["role"];
$isOwner = $plant["user_id"] == $_SESSION["user"]["id"];
authorize($isOwner || in_array($role, ["moderator", "admin"]));

$tags = $db->query("SELECT * FROM tags ORDER BY type, name")->get();

$plantTagIds = array_column(
    $db
        ->query("SELECT tag_id FROM plant_tag WHERE plant_id = :pid", [
            "pid" => $plant["id"],
        ])
        ->get(),
    "tag_id",
);

$meta = $db
    ->query("SELECT * FROM plant_meta WHERE plant_id = :pid", [
        "pid" => $plant["id"],
    ])
    ->get();

$media = MediaService::getForPlant($plant["id"]);

view("plants/edit.view.php", [
    "heading" => "Edit Plant",
    "plant" => $plant,
    "tags" => $tags,
    "plantTagIds" => $plantTagIds,
    "meta" => $meta,
    "media" => $media,
]);
