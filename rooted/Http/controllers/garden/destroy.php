<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$userId = $_SESSION["user"]["id"];
$gardenPlantId = (int) ($_GET["id"] ?? 0);

if ($gardenPlantId <= 0) {
    abort(404);
}

$db->query(
    "DELETE FROM garden_plants WHERE id = :id AND user_id = :user_id",
    [
        "id" => $gardenPlantId,
        "user_id" => $userId,
    ],
);

$_SESSION["_flash"]["success"] = "Plant removed from your garden.";

redirect("/my-garden");