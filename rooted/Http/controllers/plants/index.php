<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$plants = $db
    ->query("SELECT * FROM plants WHERE user_id = :user_id", [
        "user_id" => $_SESSION["user"]["id"] ?? 0,
    ])
    ->get();

view("plants/index.view.php", [
    "heading" => "My Plants",
    "plants" => $plants,
]);
