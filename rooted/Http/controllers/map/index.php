<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

// Gardens are the users who chose to share a location.
$gardens = $db
    ->query(
        "SELECT id, email, latitude, longitude
     FROM users
     WHERE latitude IS NOT NULL AND longitude IS NOT NULL",
    )
    ->get();

// Attach the plants each user grows in their personal garden.
foreach ($gardens as &$garden) {
    $garden["plants"] = $db
        ->query(
            "SELECT p.id, p.name
         FROM garden_plants gp
         INNER JOIN plants p ON p.id = gp.plant_id
         WHERE gp.user_id = :user_id
         ORDER BY p.name",
            ["user_id" => $garden["id"]],
        )
        ->get();
}
unset($garden);

view("map/index.view.php", [
    "heading" => "Garden Map",
    "gardens" => $gardens,
]);
