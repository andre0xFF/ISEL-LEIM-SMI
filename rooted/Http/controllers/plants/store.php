<?php

use Core\App;
use Core\Database;
use Core\MediaService;
use Core\NotificationService;
use Core\Validator;

$db = App::resolve(Database::class);

$name = $_POST["name"] ?? "";
$body = $_POST["body"] ?? "";
$visibility = $_POST["visibility"] ?? "public";

// Validate
$errors = [];
if (!Validator::string($name, 1, 255)) {
    $errors["name"] = "Name is required.";
}
if (!in_array($visibility, ["public", "internal"])) {
    $errors["visibility"] = "Visibility must be public or internal.";
}

if (!empty($errors)) {
    $tags = $db->query("SELECT * FROM tags ORDER BY type, name")->get();
    return view("plants/create.view.php", [
        "heading" => "Create Plant",
        "errors" => $errors,
        "tags" => $tags,
    ]);
}

// Insert plant
$db->query(
    "INSERT INTO plants (user_id, name, body, visibility) VALUES (:user_id, :name, :body, :visibility)",
    [
        "user_id" => $_SESSION["user"]["id"],
        "name" => $name,
        "body" => $body,
        "visibility" => $visibility,
    ],
);
$plantId = (int) $db->lastInsertId();

// Process media uploads
if (!empty($_FILES["media"]["name"][0])) {
    MediaService::storeMultiple($_FILES["media"], $plantId);
}

// Process tags
$tagIds = $_POST["tags"] ?? [];
foreach ($tagIds as $tagId) {
    $db->query("INSERT INTO plant_tag (plant_id, tag_id) VALUES (:pid, :tid)", [
        "pid" => $plantId,
        "tid" => (int) $tagId,
    ]);
}

// Process meta-information
$metaKeys = $_POST["meta_keys"] ?? [];
$metaValues = $_POST["meta_values"] ?? [];
for ($i = 0; $i < count($metaKeys); $i++) {
    $k = trim($metaKeys[$i] ?? "");
    $v = trim($metaValues[$i] ?? "");
    if ($k === "" && $v === "") {
        continue;
    }
    $db->query(
        "INSERT INTO plant_meta (plant_id, `key`, `value`) VALUES (:pid, :k, :v)",
        [
            "pid" => $plantId,
            "k" => $k,
            "v" => $v,
        ],
    );
}

// Notify subscribers
NotificationService::notifyNewPlant($plantId);

redirect("/plant?id={$plantId}");
