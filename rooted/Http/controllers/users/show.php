<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$user = $db
    ->query("SELECT * FROM users WHERE id = :id", [
        "id" => $_GET["id"],
    ])
    ->findOrFail();

view("users/show.view.php", [
    "heading" => "User",
    "user" => $user,
]);
