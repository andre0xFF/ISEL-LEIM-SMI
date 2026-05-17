<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$user = $db->query("SELECT * FROM users WHERE id = :id", [
    "id" => $_SESSION["user"]["id"],
])->findOrFail();

$email = trim($_POST["email"] ?? "");
$currentPassword = $_POST["current_password"] ?? "";
$newPassword = $_POST["new_password"] ?? "";
$passwordConfirmation = $_POST["password_confirmation"] ?? "";

$errors = [];

// Validate email
if ($email === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors["email"] = "A valid email address is required.";
}

// If email changed, check uniqueness
if ($email !== "" && $email !== $user["email"]) {
    $existing = $db->query("SELECT id FROM users WHERE email = :email", [
        "email" => $email,
    ])->find();

    if ($existing) {
        $errors["email"] = "That email is already taken.";
    }
}

// If new password provided, validate
if ($newPassword !== "") {
    if (!password_verify($currentPassword, $user["password"])) {
        $errors["current_password"] = "Current password is incorrect.";
    }

    if (strlen($newPassword) < 7) {
        $errors["new_password"] = "New password must be at least 7 characters.";
    }

    if ($newPassword !== $passwordConfirmation) {
        $errors["password_confirmation"] = "Password confirmation does not match.";
    }
}

if (!empty($errors)) {
    $_SESSION["_flash"]["errors"] = $errors;
    return redirect("/profile");
}

// Build update query
$emailChanged = $email !== $user["email"];

if ($newPassword !== "") {
    $db->query(
        "UPDATE users SET email = :email, password = :password, email_verified = :verified WHERE id = :id",
        [
            "email" => $email,
            "password" => password_hash($newPassword, PASSWORD_BCRYPT),
            "verified" => $emailChanged ? 0 : $user["email_verified"],
            "id" => $user["id"],
        ],
    );
} else {
    $db->query(
        "UPDATE users SET email = :email, email_verified = :verified WHERE id = :id",
        [
            "email" => $email,
            "verified" => $emailChanged ? 0 : $user["email_verified"],
            "id" => $user["id"],
        ],
    );
}

// Update session email
$_SESSION["user"]["email"] = $email;

redirect("/profile");
