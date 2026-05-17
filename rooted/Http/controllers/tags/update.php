<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$tag = $db->query("SELECT * FROM tags WHERE id = :id", [
    "id" => $_GET["id"],
])->findOrFail();

$role = $_SESSION["user"]["role"];

if ($role === "admin") {
    // admin can edit any tag
} elseif ($role === "moderator") {
    authorize($tag["user_id"] == $_SESSION["user"]["id"] && $tag["type"] === "secondary");
} else {
    abort(403);
}

$name = trim($_POST["name"] ?? "");

$errors = [];

if ($name === "") {
    $errors["name"] = "Tag name is required.";
}

if ($name !== "" && $name !== $tag["name"]) {
    $existing = $db->query("SELECT id FROM tags WHERE name = :name", [
        "name" => $name,
    ])->find();

    if ($existing) {
        $errors["name"] = "A tag with that name already exists.";
    }
}

if (!empty($errors)) {
    $_SESSION["_flash"]["errors"] = $errors;
    return redirect("/tag/edit?id=" . $tag["id"]);
}

if ($role === "admin") {
    $type = $_POST["type"] ?? $tag["type"];
    if (!in_array($type, ["primary", "secondary"])) {
        $type = $tag["type"];
    }

    $db->query("UPDATE tags SET name = :name, type = :type WHERE id = :id", [
        "name" => $name,
        "type" => $type,
        "id" => $tag["id"],
    ]);
} else {
    $db->query("UPDATE tags SET name = :name WHERE id = :id", [
        "name" => $name,
        "id" => $tag["id"],
    ]);
}

redirect("/tags");
