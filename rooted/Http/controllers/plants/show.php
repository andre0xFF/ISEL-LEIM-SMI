<?php

use Core\App;
use Core\Database;
use Core\MediaService;

$db = App::resolve(Database::class);

$plant = $db
    ->query(
        "SELECT p.*, u.email as author_email FROM plants p JOIN users u ON u.id = p.user_id WHERE p.id = :id",
        [
            "id" => $_GET["id"],
        ],
    )
    ->findOrFail();

// Visibility check: internal plants require authentication
$isGuest = !($_SESSION["user"] ?? false);
if ($plant["visibility"] === "internal" && $isGuest) {
    abort(403);
}

// Load related data
$media = MediaService::getForPlant($plant["id"]);

$tags = $db
    ->query(
        "SELECT t.* FROM tags t INNER JOIN plant_tag pt ON pt.tag_id = t.id WHERE pt.plant_id = :pid",
        ["pid" => $plant["id"]],
    )
    ->get();

$meta = $db
    ->query("SELECT * FROM plant_meta WHERE plant_id = :pid", [
        "pid" => $plant["id"],
    ])
    ->get();

// Can the current user edit this plant?
$canEdit = false;
if ($_SESSION["user"] ?? false) {
    $role = $_SESSION["user"]["role"];
    $canEdit =
        $plant["user_id"] == $_SESSION["user"]["id"] ||
        in_array($role, ["moderator", "admin"]);
}

// Load weather data if the plant has Latitude/Longitude meta
$weather = null;
$lat = null;
$lng = null;
foreach ($meta as $m) {
    if ($m["key"] === "Latitude") {
        $lat = (float) $m["value"];
    }
    if ($m["key"] === "Longitude") {
        $lng = (float) $m["value"];
    }
}
if ($lat !== null && $lng !== null) {
    $weather = \Core\WeatherService::getWeather($lat, $lng);
}

view("plants/show.view.php", [
    "heading" => $plant["name"],
    "plant" => $plant,
    "media" => $media,
    "tags" => $tags,
    "meta" => $meta,
    "canEdit" => $canEdit,
    "weather" => $weather,
]);
