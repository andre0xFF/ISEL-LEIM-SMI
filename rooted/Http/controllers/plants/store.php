<?php

use Core\App;
use Core\Database;

// TODO: Add validation logic.

$db = App::resolve(Database::class);

$db->query("INSERT INTO plants(name, user_id) VALUES(:name, :user_id)", [
    "name" => $_POST["name"],
    "user_id" => $_SESSION["user"]["id"] ?? 1,
]);

header("location: /plants");
die();
