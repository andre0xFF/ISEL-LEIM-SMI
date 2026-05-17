<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);
$tags = $db->query("SELECT * FROM tags ORDER BY type, name")->get();

view("plants/create.view.php", [
    "heading" => "Create Plant",
    "errors" => [],
    "tags" => $tags,
]);
