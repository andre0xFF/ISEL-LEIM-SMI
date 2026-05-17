<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$user = $db
    ->query("SELECT * FROM users WHERE id = :id", [
        "id" => $_GET["id"],
    ])
    ->findOrFail();

$email = trim($_POST["email"] ?? "");
$role = $_POST["role"] ?? $user["role"];
$newPassword = $_POST["new_password"] ?? "";

$errors = [];

// Validate email
if ($email === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors["email"] = "A valid email address is required.";
}

// Check uniqueness excluding this user
if ($email !== "" && $email !== $user["email"]) {
    $existing = $db
        ->query("SELECT id FROM users WHERE email = :email AND id != :id", [
            "email" => $email,
            "id" => $user["id"],
        ])
        ->find();

    if ($existing) {
        $errors["email"] = "That email is already taken.";
    }
}

// Validate role
if (!in_array($role, ["admin", "moderator", "user"])) {
    $errors["role"] = "Role must be admin, moderator, or user.";
}

if (!empty($errors)) {
    $_SESSION["_flash"]["errors"] = $errors;
    return redirect("/user/edit?id=" . $user["id"]);
}

if ($newPassword !== "") {
    $db->query(
        "UPDATE users SET email = :email, role = :role, password = :password WHERE id = :id",
        [
            "email" => $email,
            "role" => $role,
            "password" => password_hash($newPassword, PASSWORD_BCRYPT),
            "id" => $user["id"],
        ],
    );
} else {
    $db->query("UPDATE users SET email = :email, role = :role WHERE id = :id", [
        "email" => $email,
        "role" => $role,
        "id" => $user["id"],
    ]);
}

redirect("/users");
