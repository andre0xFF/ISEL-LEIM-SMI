<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$tag = $db->query("SELECT * FROM tags WHERE id = :id", [
    "id" => $_GET["id"],
])->findOrFail();

$role = $_SESSION["user"]["role"];

if ($role === "admin") {
    // admin can delete any tag
} elseif ($role === "moderator") {
    authorize($tag["user_id"] == $_SESSION["user"]["id"] && $tag["type"] === "secondary");
} else {
    abort(403);
}

$db->query("DELETE FROM tags WHERE id = :id", [
    "id" => $tag["id"],
]);

redirect("/tags");
