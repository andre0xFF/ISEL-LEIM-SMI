<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$currentUserId = $_SESSION["user"]["id"] ?? null;

$plant = $db
    ->query("SELECT * FROM plants WHERE id = :id", [
        "id" => $_GET["id"],
    ])
    ->findOrFail();

authorize($plant["user_id"] === $currentUserId);

view("plants/show.view.php", [
    "heading" => "Plant",
    "plant" => $plant,
]);
