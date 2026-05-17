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

// TODO: validate input

$db->query(
    "UPDATE plants SET name = :name, body = :body, visibility = :visibility WHERE id = :id",
    [
        "name" => $_POST["name"],
        "body" => $_POST["body"],
        "visibility" => $_POST["visibility"],
        "id" => $_GET["id"],
    ],
);

redirect("/plants");
