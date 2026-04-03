<?php

return [
    "database" => [
        "host" => getenv("DB_HOST") ?: "localhost",
        "port" => (int) (getenv("DB_PORT") ?: 3306),
        "dbname" => getenv("DB_NAME") ?: "rooted",
        "charset" => "utf8mb4",
    ],

    "username" => getenv("DB_USER") ?: "root",
    "password" => getenv("DB_PASSWORD") ?: "",
];
