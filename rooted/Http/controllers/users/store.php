<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";
$role = $_POST["role"] ?? "user";

$errors = [];

// Validate email
if ($email === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors["email"] = "A valid email address is required.";
}

if ($email !== "" && filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $existing = $db
        ->query("SELECT id FROM users WHERE email = :email", [
            "email" => $email,
        ])
        ->find();

    if ($existing) {
        $errors["email"] = "That email is already taken.";
    }
}

// Validate password
if (strlen($password) < 7) {
    $errors["password"] = "Password must be at least 7 characters.";
}

// Validate role
if (!in_array($role, ["admin", "moderator", "user"])) {
    $errors["role"] = "Role must be admin, moderator, or user.";
}

if (!empty($errors)) {
    return view("users/create.view.php", [
        "heading" => "Create User",
        "errors" => $errors,
    ]);
}

$db->query(
    "INSERT INTO users (email, password, role, created_at) VALUES (:email, :password, :role, NOW())",
    [
        "email" => $email,
        "password" => password_hash($password, PASSWORD_BCRYPT),
        "role" => $role,
    ],
);

redirect("/users");
