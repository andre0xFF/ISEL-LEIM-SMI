<?php

use Core\PlantNetService;

if (empty($_FILES["image"]["tmp_name"])) {
    http_response_code(400);
    header("Content-Type: application/json");
    echo json_encode(["error" => "No image provided."]);
    exit();
}

$results = PlantNetService::identify($_FILES["image"]["tmp_name"]);

header("Content-Type: application/json");
echo json_encode(["results" => $results ?? []]);
exit();
