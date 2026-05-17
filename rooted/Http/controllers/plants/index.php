<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$q = $_GET["q"] ?? "";
$tagFilter = $_GET["tag"] ?? "";
$isGuest = !($_SESSION["user"] ?? false);

// Base query — join with tags and meta for search
$sql = "SELECT DISTINCT p.* FROM plants p";
$params = [];

if ($tagFilter) {
    $sql .= " INNER JOIN plant_tag pt ON pt.plant_id = p.id";
    $sql .= " AND pt.tag_id = :tag_id";
    $params["tag_id"] = $tagFilter;
}

if ($q) {
    $sql .= " LEFT JOIN plant_meta pm ON pm.plant_id = p.id";
}

$conditions = [];

// Visibility: guests see public only, authenticated see all
if ($isGuest) {
    $conditions[] = "p.visibility = 'public'";
}

// Text search across name, body, and meta values
if ($q) {
    $conditions[] = "(p.name LIKE :q OR p.body LIKE :q OR pm.value LIKE :q)";
    $params["q"] = "%{$q}%";
}

if ($conditions) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$sql .= " ORDER BY p.created_at DESC";

$plants = $db->query($sql, $params)->get();

// Get all tags for the filter sidebar
$tags = $db->query("SELECT * FROM tags ORDER BY type, name")->get();

view("plants/index.view.php", [
    "heading" => "Plants",
    "plants" => $plants,
    "tags" => $tags,
    "q" => $q,
    "tagFilter" => $tagFilter,
]);
