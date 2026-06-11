<?php

$config = [
    "database" => [
        "host" => getenv("DB_HOST") ?: "localhost",
        "port" => (int) (getenv("DB_PORT") ?: 3306),
        "dbname" => getenv("DB_NAME") ?: "rooted",
        "charset" => "utf8mb4",
    ],

    "username" => getenv("DB_USER") ?: "root",
    "password" => getenv("DB_PASSWORD") ?: "root",
];

// Local override written by the first-run installer (/install/database).
// Takes precedence over the env/default values above.
$localOverride = __DIR__ . "/storage/config.local.php";

if (is_file($localOverride)) {
    $local = require $localOverride;

    if (is_array($local)) {
        $config = array_replace_recursive($config, $local);
    }
}

return $config;
