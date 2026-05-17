<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$tags = $db->query("SELECT * FROM tags ORDER BY type, name")->get();

view("tags/index.view.php", [
    "heading" => "Tags",
    "tags" => $tags,
]);
