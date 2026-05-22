<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$userId = $_SESSION["user"]["id"];

$gardenPlants = $db->query(
    "SELECT
         gp.id,
         gp.notes,
         gp.created_at as garden_created_at,
         p.id as plant_id,
         p.name,
         p.body,
         p.visibility
    FROM garden_plants gp
    JOIN plants p ON p.id = gp.plant_id
    WHERE gp.user_id = :user_id
    ORDER BY gp.created_at DESC",
    [
        "user_id" => $userId,
    ],
)->get();


view("garden/index.view.php", [
    "heading" => "My Garden",
    "gardenPlants" => $gardenPlants,
]);




