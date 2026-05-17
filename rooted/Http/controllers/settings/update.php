<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$keys = [
    "smtp_host",
    "smtp_port",
    "smtp_user",
    "smtp_password",
    "smtp_from_address",
    "smtp_from_name",
    "app_name",
    "app_url",
];

foreach ($keys as $key) {
    $value = $_POST[$key] ?? "";

    $db->query(
        "INSERT INTO settings (`key`, value) VALUES (:k, :v) ON DUPLICATE KEY UPDATE value = :v2",
        [
            "k" => $key,
            "v" => $value,
            "v2" => $value,
        ],
    );
}

redirect("/settings");
