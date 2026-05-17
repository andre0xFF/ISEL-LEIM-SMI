<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$user = $db->query("SELECT * FROM users WHERE id = :id", [
    "id" => $_SESSION["user"]["id"],
])->findOrFail();

view("profile/edit.view.php", [
    "heading" => "My Profile",
    "user" => $user,
]);
