<?php

use Core\App;
use Core\Database;
use Core\EmailVerificationService;
use Core\Validator;

$db = App::resolve(Database::class);

$user = $db
    ->query("SELECT * FROM users WHERE id = :id", [
        "id" => $_SESSION["user"]["id"],
    ])
    ->findOrFail();

$email = trim($_POST["email"] ?? "");
$currentPassword = $_POST["current_password"] ?? "";
$newPassword = $_POST["new_password"] ?? "";
$passwordConfirmation = $_POST["password_confirmation"] ?? "";
$latitudeRaw = trim($_POST["latitude"] ?? "");
$longitudeRaw = trim($_POST["longitude"] ?? "");

$errors = [];

// Validate garden location (optional). Both coordinates are set together or cleared together.
$latitude = null;
$longitude = null;
if ($latitudeRaw !== "" || $longitudeRaw !== "") {
    if (!is_numeric($latitudeRaw) || $latitudeRaw < -90 || $latitudeRaw > 90) {
        $errors["latitude"] = "Latitude must be a number between -90 and 90.";
    } else {
        $latitude = (float) $latitudeRaw;
    }

    if (
        !is_numeric($longitudeRaw) ||
        $longitudeRaw < -180 ||
        $longitudeRaw > 180
    ) {
        $errors["longitude"] =
            "Longitude must be a number between -180 and 180.";
    } else {
        $longitude = (float) $longitudeRaw;
    }
}

// Validate email
if ($email === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors["email"] = "A valid email address is required.";
}

// If email changed, check uniqueness
if ($email !== "" && $email !== $user["email"]) {
    $existing = $db
        ->query("SELECT id FROM users WHERE email = :email", [
            "email" => $email,
        ])
        ->find();

    if ($existing) {
        $errors["email"] = "That email is already taken.";
    }
}

// If new password provided, validate
if ($newPassword !== "") {
    if (!password_verify($currentPassword, $user["password"])) {
        $errors["current_password"] = "Current password is incorrect.";
    }

    if (!Validator::string($newPassword, 7, 255)) {
        $errors["new_password"] = "New password must be at least 7 characters.";
    } elseif (!Validator::strongPassword($newPassword)) {
        $errors["new_password"] =
            "Password must include at least one letter, one number, and one special character.";
    }

    if (!Validator::matches($newPassword, $passwordConfirmation)) {
        $errors["password_confirmation"] =
            "Password confirmation does not match.";
    }
}

if (!empty($errors)) {
    $_SESSION["_flash"]["errors"] = $errors;
    return redirect("/profile");
}

// Build update query
$emailChanged = $email !== $user["email"];

if ($emailChanged) {
    $sendSuccess = EmailVerificationService::sendForUser(
        (int) $user["id"],
        $email,
    );

    if (!$sendSuccess) {
        $_SESSION["_flash"]["errors"] = [
            "email" =>
                "We could not send a verification email to the new address. Your email was not changed.",
        ];
        return redirect("/profile");
    }
}

if ($newPassword !== "") {
    $db->query(
        "UPDATE users SET email = :email, password = :password, email_verified = :verified, latitude = :latitude, longitude = :longitude WHERE id = :id",
        [
            "email" => $email,
            "password" => password_hash($newPassword, PASSWORD_BCRYPT),
            "verified" => $emailChanged ? 0 : $user["email_verified"],
            "latitude" => $latitude,
            "longitude" => $longitude,
            "id" => $user["id"],
        ],
    );
} else {
    $db->query(
        "UPDATE users SET email = :email, email_verified = :verified, latitude = :latitude, longitude = :longitude WHERE id = :id",
        [
            "email" => $email,
            "verified" => $emailChanged ? 0 : $user["email_verified"],
            "latitude" => $latitude,
            "longitude" => $longitude,
            "id" => $user["id"],
        ],
    );
}

// Update session email
$_SESSION["user"]["email"] = $email;

if ($emailChanged) {
    $_SESSION["_flash"]["success"] =
        "Your email address was updated. Please check your new inbox to verify it.";
} else {
    $_SESSION["_flash"]["success"] = "Your profile was updated.";
}

redirect("/profile");
