<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$currentUserId = $_SESSION["user"]["id"] ?? null;

authorize($currentUserId);

$id = $_GET["id"];

$user = $db
    ->query("SELECT * FROM users WHERE id = :id", [
        "id" => $id,
    ])
    ->findOrFail();

authorize($user["id"] === $currentUserId);

$db->query("DELETE FROM users WHERE id = :id", [
    "id" => $id,
]);

redirect("/");
