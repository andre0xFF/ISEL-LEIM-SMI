<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$plant = $db
    ->query("SELECT * FROM plants WHERE id = :id", [
        "id" => $_GET["id"],
    ])
    ->findOrFail();

authorize($plant["user_id"] === $_SESSION["user"]["id"]);

view("plants/show.view.php", [
    "heading" => "Plant",
    "plant" => $plant,
]);
