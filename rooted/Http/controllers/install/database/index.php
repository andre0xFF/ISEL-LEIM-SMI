<?php

use Core\Installer;

// Already fully installed — nothing to do here.
if (Installer::state() === "ready") {
    redirect("/");
}

$config = Installer::config();

view("install/database.view.php", [
    "errors" => [],
    "values" => [
        "db_host" => $config["database"]["host"],
        "db_port" => (string) $config["database"]["port"],
        "db_name" => $config["database"]["dbname"],
        "db_user" => $config["username"],
    ],
]);
