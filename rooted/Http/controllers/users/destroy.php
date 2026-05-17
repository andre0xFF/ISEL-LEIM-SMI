<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$user = $db
    ->query("SELECT * FROM users WHERE id = :id", [
        "id" => $_GET["id"],
    ])
    ->findOrFail();

// Prevent self-deletion
authorize($user["id"] !== $_SESSION["user"]["id"]);

$db->query("DELETE FROM users WHERE id = :id", [
    "id" => $user["id"],
]);

redirect("/users");
