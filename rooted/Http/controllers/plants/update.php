<?php

use Core\App;
use Core\Database;
use Core\MediaService;
use Core\Validator;

$db = App::resolve(Database::class);

$plant = $db
    ->query("SELECT * FROM plants WHERE id = :id", ["id" => $_GET["id"]])
    ->findOrFail();

$role = $_SESSION["user"]["role"];
$isOwner = $plant["user_id"] == $_SESSION["user"]["id"];
authorize($isOwner || in_array($role, ["moderator", "admin"]));

$name = $_POST["name"] ?? "";
$body = $_POST["body"] ?? "";
$visibility = $_POST["visibility"] ?? "public";

$errors = [];
if (!Validator::string($name, 1, 255)) {
    $errors["name"] = "Name is required.";
}

if (!empty($errors)) {
    $_SESSION["_flash"]["errors"] = $errors;
    return redirect("/plant/edit?id=" . $plant["id"]);
}

$db->query(
    "UPDATE plants SET name = :name, body = :body, visibility = :visibility WHERE id = :id",
    [
        "name" => $name,
        "body" => $body,
        "visibility" => $visibility,
        "id" => $plant["id"],
    ],
);

// Handle new media uploads
if (!empty($_FILES["media"]["name"][0])) {
    MediaService::storeMultiple($_FILES["media"], $plant["id"]);
}

// Delete media marked for removal
$deleteMedia = $_POST["delete_media"] ?? [];
foreach ($deleteMedia as $mediaId) {
    MediaService::delete((int) $mediaId);
}

// Sync tags: delete old, insert new
$db->query("DELETE FROM plant_tag WHERE plant_id = :pid", [
    "pid" => $plant["id"],
]);
$tagIds = $_POST["tags"] ?? [];
foreach ($tagIds as $tagId) {
    $db->query("INSERT INTO plant_tag (plant_id, tag_id) VALUES (:pid, :tid)", [
        "pid" => $plant["id"],
        "tid" => (int) $tagId,
    ]);
}

// Sync meta: delete old, insert new
$db->query("DELETE FROM plant_meta WHERE plant_id = :pid", [
    "pid" => $plant["id"],
]);
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
            "pid" => $plant["id"],
            "k" => $k,
            "v" => $v,
        ],
    );
}

redirect("/plant?id=" . $plant["id"]);
