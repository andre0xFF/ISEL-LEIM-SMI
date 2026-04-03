<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$currentUserId = $_SESSION["user"]["id"] ?? null;

authorize($currentUserId);

$plant = $db
    ->query("SELECT * FROM plants WHERE id = :id", [
        "id" => $_GET["id"],
    ])
    ->findOrFail();

authorize($plant["user_id"] === $currentUserId);

// TODO: validate input

$db->query(
    "UPDATE plants SET name = :name, species = :species, notes = :notes WHERE id = :id",
    [
        "name" => $_POST["name"],
        "species" => $_POST["species"],
        "notes" => $_POST["notes"],
        "id" => $_GET["id"],
    ],
);

redirect("/plants");
