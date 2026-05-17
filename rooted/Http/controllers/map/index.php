<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

// Get plants with both Latitude and Longitude meta
$plants = $db->query(
    "SELECT p.id, p.name, p.body,
            lat.value AS latitude, lng.value AS longitude
     FROM plants p
     INNER JOIN plant_meta lat ON lat.plant_id = p.id AND lat.`key` = 'Latitude'
     INNER JOIN plant_meta lng ON lng.plant_id = p.id AND lng.`key` = 'Longitude'
     WHERE p.visibility = 'public'
     ORDER BY p.created_at DESC"
)->get();

view("map/index.view.php", [
    "heading" => "Plant Map",
    "plants" => $plants,
]);
