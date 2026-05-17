<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$rows = $db->query("SELECT * FROM settings")->get();

$settings = [];
foreach ($rows as $row) {
    $settings[$row["key"]] = $row["value"];
}

view("settings/edit.view.php", [
    "heading" => "Settings",
    "settings" => $settings,
]);
