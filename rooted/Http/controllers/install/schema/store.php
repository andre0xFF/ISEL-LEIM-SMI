<?php

use Core\Installer;

if (Installer::state() !== "schema_missing") {
    redirect("/");
}

$config = Installer::config();

try {
    Installer::runSchema($config);
} catch (PDOException $e) {
    return view("install/schema.view.php", [
        "errors" => [
            "schema" => "Schema initialization failed: " . $e->getMessage(),
        ],
        "dbname" => $config["database"]["dbname"],
    ]);
}

// Schema is in place — continue to the first admin + SMTP setup.
redirect("/setup");
