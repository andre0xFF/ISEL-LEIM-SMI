<?php


use Core\App;
use Core\Database;


$db = App::resolve(Database::class);

$userId = $_SESSION["user"]["id"];
$plantId = (int) ($_POST["plant_id"] ?? 0);


if($plantId <= 0){
    abort(404);
}

$plant = $db->query(
    "SELECT id FROM plants WHERE id = :id",
    [
        "id" => $plantId,
    ],

)->find();

if(!$plant){
    abort(404);
}

$existing = $db->query(
    "SELECT id FROM garden_plants WHERE user_id = :user_id AND plant_id = :plant_id",
    [
        "user_id" => $userId,
        "plant_id" => $plantId,
    ],
)->find();

if (!$existing) {
    $db->query(
        "INSERT INTO garden_plants (user_id, plant_id) VALUES (:user_id, :plant_id)",
        [
            "user_id" => $userId,
            "plant_id" => $plantId,
        ],
    );

    $_SESSION["_flash"]["success"] = "Plant added to your garden.";
}else{
    $_SESSION["_flash"]["success"] = "This plant is already in your garden.";
}

redirect("/my-garden");
