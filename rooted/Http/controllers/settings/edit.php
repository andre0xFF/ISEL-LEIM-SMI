<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$rows = $db->query("SELECT * FROM settings")->get();

$settings = [];
foreach ($rows as $row) {
    $settings[$row["key"]] = $row["value"];
}

// Current DB connection values (from config.php + local override),
// used to pre-fill the Database section of the settings page.
$config = require base_path("config.php");

view("settings/edit.view.php", [
    "heading" => "Settings",
    "settings" => $settings,
    "dbValues" => [
        "db_host" => $config["database"]["host"],
        "db_port" => (string) $config["database"]["port"],
        "db_name" => $config["database"]["dbname"],
        "db_user" => $config["username"],
    ],
]);
