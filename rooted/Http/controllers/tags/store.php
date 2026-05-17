<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$name = trim($_POST["name"] ?? "");
$role = $_SESSION["user"]["role"];

if ($role === "moderator") {
    $type = "secondary";
} else {
    $type = $_POST["type"] ?? "primary";
    if (!in_array($type, ["primary", "secondary"])) {
        $type = "primary";
    }
}

// Validate
$errors = [];

if ($name === "") {
    $errors["name"] = "Tag name is required.";
}

if ($name !== "") {
    $existing = $db->query("SELECT id FROM tags WHERE name = :name", [
        "name" => $name,
    ])->find();

    if ($existing) {
        $errors["name"] = "A tag with that name already exists.";
    }
}

if (!empty($errors)) {
    return view("tags/create.view.php", [
        "heading" => "Create Tag",
        "errors" => $errors,
    ]);
}

$db->query(
    "INSERT INTO tags (name, type, user_id, created_at) VALUES (:name, :type, :user_id, NOW())",
    [
        "name" => $name,
        "type" => $type,
        "user_id" => $_SESSION["user"]["id"],
    ],
);

redirect("/tags");
