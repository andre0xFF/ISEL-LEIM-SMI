<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$currentUserId = $_SESSION["user"]["id"] ?? null;

authorize($currentUserId);

$id = $_GET["id"];

$plant = $db
    ->query("SELECT * FROM plants WHERE id = :id", [
        "id" => $id,
    ])
    ->findOrFail();

authorize($plant["user_id"] === $currentUserId);

$db->query("DELETE FROM plants WHERE id = :id", [
    "id" => $id,
]);

redirect("/plants");
